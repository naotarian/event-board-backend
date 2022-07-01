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

class GetEventTest extends TestCase
{
    use RefreshDatabase;
    // use DatabaseTransactions;
    private $accessToken = null;

    protected function setUp(): Void
    {
        // 必ずparent::setUp()を呼び出す
        parent::setUp(); 
        $user = User::factory()->create();
        $response = $this->actingAs($user)
        ->withSession(['banned' => false])
        ->get('/');
    }
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function test_get_events()
    {
        $response = $this->get('/api/get_events');
        $response->dump();
        $response->assertStatus(200);
    }
}
