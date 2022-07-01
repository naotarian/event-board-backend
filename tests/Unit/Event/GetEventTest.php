<?php

namespace Tests\Unit\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Database\Seeders\AreasSeeder;
use Database\Seeders\TagCategoriesSeeder;
use Database\Seeders\TagsSeeder;
use Carbon\Carbon;

class GetEventTest extends TestCase
{
    use RefreshDatabase;
    // use DatabaseTransactions;
    private $accessToken = null;

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
        $test = $this->post('/api/create_event' ,[
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
    }
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function test_イベント取得()
    {
        $response = $this->get('/api/get_events');
        $response->dump();
        $response->assertStatus(200);
    }
}
