<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Event;
use App\Models\Area;
use App\Models\TagCategory;
use App\Models\Tag;
use App\Models\ApplicationManagement;
use App\Models\EventCrowdManagement;
//Libraries
use Carbon\Carbon;
//Mail
use Mail;
use App\Mail\ComplateApplication;
use App\Mail\AlreadyApplication;

class EventController extends Controller
{
    public function __construct() {
        $this->aes_key = config('app.aes_key');
        $this->aes_type = config('app.aes_type');
    }
    public function create_event(Request $request) {
        $post_user = json_decode($request->user(), true);
        $new_event = new Event;
        preg_match('/東京都|北海道|(?:京都|大阪)府|.{6,9}県/', $request['address'], $area);
        $area_id = Area::select(['id'])->where('area_name', $area[0])->first();
        $new_event->user_id = $post_user['id'];
        $new_event->title = $request['eventTitle'];
        $new_event->event_date = $request['eventDate'];
        $new_event->post_code = $request['zipCode'];
        $new_event->address = $request['address'];
        $new_event->other_address = $request['otherAddress'];
        $new_event->event_start = $request['startTime'];
        $new_event->event_end = $request['endTime'];
        $new_event->recruit_start = $request['rangeStartValue'];
        $new_event->recruit_end = $request['rangeEndValue'];
        $new_event->overview = $request['overview'];
        $new_event->theme = $request['eventTheme'];
        $new_event->email = $request['email'];
        $new_event->recommendation = $request['recommendation'];
        $new_event->number_of_applicants = $request['numberOfApplicants'];
        $new_event->notes = $request['notes'];
        $new_event->area_id = $area_id['id'];
        $tag_int = [];
        if($request['event_tags']) {
            foreach($request['event_tags'] as $tag) {
                array_push($tag_int, intval($tag));
            }
        }
        $new_event->event_tags = $tag_int;
        $new_event->save();
        //人数管理テーブル作成
        $crowd = new EventCrowdManagement;
        $crowd->event_id = $new_event->id;
        $crowd->number_of_applicants = $new_event->number_of_applicants;
        $crowd->save();
        $res = ['code' => 200];
        return response()->json($res);
    }

    public function get_events() {
        $contents = [];
        $contents['events'] = Event::with('user')->get()->toArray();
        $contents['events'] = $this->__event_tags($contents['events']);
        $contents['areas'] = Area::select(['id', 'area_name'])->orderBy('display_order', 'asc')->get();
        $contents['tags'] = Tag::limit(10)->get();
        $res = ['status' => 'OK', 'contents' => $contents];
        return response()->json($res);
    }
    public function event_search(Request $request) {
        $query = Event::query();
        if($request['keyWord']) {
            //キーワード検索
            $keyword = '%' . addcslashes($request['keyWord'], '%_\\') . '%';
            $query->where('title', 'LIKE', $keyword);
        }
        if($request['areas']) {
            //エリア検索
            $query->whereIn('area_id', $request['areas']);
        }
        $events = $query->with('user')->get();
        $res = ['status' => 'OK', 'contents' => $events];
        return response()->json($res);
    }
    public function event_detail(Request $request) {
        \Log::info($request);
        $auth_user = json_decode($request->user(), true);
        $contents = [];
        $contents['event_info'] = Event::with('user')->with('event_crowd_management')->find($request['id']);
        if($auth_user) {
            $already = ApplicationManagement::where('user_id', $auth_user['id'])->get();
            $already_list = [];
            if($already) {
                foreach($already as $data) {
                    array_push($already_list, $data['event_id']);
                }
                $contents['event_info']['already_applications'] = $already_list;
            } else {
                $contents['event_info']['already_applications'] = null;
            }
        } else {
            $contents['event_info']['already_applications'] = null;
        }
        $contents['event_info']['set_tags'] = Tag::whereIn('id', $contents['event_info']['event_tags'])->get();
        $res = ['status' => 'OK', 'contents' => $contents];
        return response()->json($res);
    }
    public function event_tag_search(Request $request) {
        $events = Event::with('user')->whereJsonContains('event_tags', [intval($request['tagId'])])->get()->toArray();
        $events = $this->__event_tags($events);
        $res = ['status' => 'OK', 'contents' => $events];
        return response()->json($res);
    }

    public function __event_tags($events) {
        foreach($events as &$event) {
            $event['id_tagname'] = [];
            if($event['event_tags']) {
                foreach($event['event_tags'] as $tag){
                    $select_tag = Tag::find($tag);
                    $id = $select_tag['id'];
                    $tag_name = $select_tag['tag_name'];
                    $event['id_tagname'][$id] = $tag_name;
                }
            }
        }
        return $events;
    }

    public function get_tags() {
        $contents = [];
        $contents['tags'] = TagCategory::with('tags')->get();
        $res = ['status' => 'OK', 'contents' => $contents];
        return response()->json($res);
    }

    //申込処理
    public function event_application(Request $request) {
        $application = new ApplicationManagement;
        $application->application_date = Carbon::now();
        $application->event_id = $request['eventId'];
        if($request['guestFlag']) {
            //未ログイン(ゲスト)
            $is_already = ApplicationManagement::where('event_id', $request['eventId'])
                                                    ->where('email', openssl_encrypt($request['email'], $this->aes_type, $this->aes_key))
                                                    ->count() == 0 ? false : true;
            \Log::info($is_already);
            if($is_already) {
                $msg = 'すでに申込済みのメールアドレスです。';
            } else {
                $application->user_id = 0;
                $application->user_name = openssl_encrypt($request['userName'], $this->aes_type, $this->aes_key);
                $application->email = openssl_encrypt($request['email'], $this->aes_type, $this->aes_key);
                $application->save();
            }
            
        } else {
            //ログインユーザー
            $auth_user = json_decode($request->user(), true);
            $request['email'] = $auth_user['email'];
            $application->user_id = $auth_user['id'];
            $application->user_name = openssl_encrypt($auth_user['name'], $this->aes_type, $this->aes_key);
            $application->email = openssl_encrypt($auth_user['email'], $this->aes_type, $this->aes_key);
            $application->save();
        }
        if(!$is_already) {
            $application->application_number = hash('crc32', $application->id);
            $application->save();
            Mail::to($request['email'])->send(new ComplateApplication(false));
            $own_mail = Event::select('email')->where('id', $request['eventId'])->first();
            Mail::to($own_mail['email'])->send(new ComplateApplication(true));
            $msg = '申し込みが完了しました。';
        } else {
            Mail::to($request['email'])->send(new AlreadyApplication());
        }
        $res = ['status' => 'OK', 'msg' => $msg];
        return response()->json($res);
    }
}
