<?php

namespace Tests\Feature\Event;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Database\Seeders\AreasSeeder;
use Database\Seeders\TagCategoriesSeeder;
use Database\Seeders\TagsSeeder;
use Carbon\Carbon;

class EventDetailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
        protected function setUp(): Void
    {
        // 必ずparent::setUp()を呼び出す
        parent::setUp(); 
        $this->seed(AreasSeeder::class);
        $this->seed(TagCategoriesSeeder::class);
        $this->seed(TagsSeeder::class);
        $this->user = User::factory()->create();
        $response = $this->post('login', [
            'email'    => $this->user->email,
            'password' => 'password'
        ]);
        $date = Carbon::now();
        for($i = 1; $i < 10; $i++) {
            $test = $this->post('/api/create_event' ,[
                'eventTitle' => 'testタイトル' . $i,
                'eventDate' => $date->format('Y/m/d'),
                'zipCode' => '3710042',
                'address' => '群馬県前橋市日輪寺町',
                'startTime' => '2022/07/08 11:00',
                'endTime' => '2022/07/08 18:00',
                'rangeStartValue' => '2022/07/01 19:07',
                'rangeEndValue' => '2022/07/07 12:30',
                'otherAddress' => 'test' . $i,
                'overview' => 'test概要' . $i,
                'eventTheme' => 'testテーマ' . $i,
                'recommendation' => 'testおすすめ' . $i,
                'numberOfApplicants' => '100',
                'notes' => 'test注意' . $i,
                'email' => 'test@test.com',
                'event_tags' => array (
                    0 => '1',
                    1 => '2',
                    2 => '3',
                ),
            ]);
        }
    }
    public function test_イベント詳細取得()
    {
        for($i = 1; $i < 3; $i++) {
            $response = $this->post('/api/event_detail', [
                'id' => $i,
                'isAuth' => 0
            ]);
            $response->dump();
            $response->assertStatus(200);
        }
    }
}
