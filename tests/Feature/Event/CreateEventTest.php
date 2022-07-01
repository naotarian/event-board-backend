<?php

namespace Tests\Feature\Event;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\AreasSeeder;
use Carbon\Carbon;
class CreateEventTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
   {
       parent::setUp();

       // テストユーザ作成
       $this->user = User::factory()->create();
       $response = $this->post('login', [
            'email'    => $this->user->email,
            'password' => 'password'
        ]);
        $this->seed(AreasSeeder::class);
   }
    public function test_イベント作成処理が正しく動作している()
    {
        $date = Carbon::now();
        $response = $this->post('/api/create_event' ,[
            'eventTitle' => 'testタイトル',
            'eventDate' => $date->format('Y/m/d'),
            'zipCode' => '3710042',
            'address' => '群馬県前橋市日輪寺町',
            'startTime' => '2022/07/08 11:00',
            'endTime' => '2022/07/08 18:00',
            'rangeStartValue' => '2022/07/01 19:07',
            'rangeEndValue' => '2022/07/07 12:30',
            'otherAddress' => 'test',
            'overview' => 'test概要',
            'eventTheme' => 'testテーマ',
            'recommendation' => 'testおすすめ',
            'numberOfApplicants' => '100',
            'notes' => 'test注意',
            'email' => 'test@test.com',
            'event_tags' => array (
                0 => '1',
                1 => '2',
                2 => '3',
            ),
        ]);

        $response->assertStatus(200);
    }
}
