<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Event;
use App\Models\Area;

class EventController extends Controller
{
    public function create_event(Request $request) {
        $post_user = json_decode($request->user(), true);
        $new_event = new Event;
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
        $new_event->notes = $request['notes'];
        $new_event->save();
        $res = ['code' => 200];
        return response()->json($res);
    }

    public function get_events(Request $request) {
        $contents = [];
        $contents['events'] = Event::all();
        $contents['areas'] = Area::select(['id', 'area_name'])->orderBy('display_order', 'asc')->get();
        $res = ['status' => 'OK', 'contents' => $contents];
        return response()->json($res);
    }
    public function event_search(Request $request) {
        $query = Event::query();
        $address1 = '東京都港区芝公園4丁目2-8';
        preg_match('/東京都|北海道|(?:京都|大阪)府|.{6,9}県/', $address1, $date_match);
        if($request['keyWord']) {
            //キーワード検索
            $keyword = '%' . addcslashes($request['keyWord'], '%_\\') . '%';
            $query->where('title', 'LIKE', $keyword);
        }
        if($request['areas']) {
            //エリア検索
            $query->whereIn('area_id', $request['areas']);
        }
        $events = $query->get();
        $res = ['status' => 'OK', 'contents' => $events];
        return response()->json($res);
    }
}
