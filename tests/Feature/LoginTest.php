<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginTest extends TestCase
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
   }
    public function test_example()
    {
        //ユーザー作成
        // $user = User::factory()->create();
        //認証されていないことを確認
        $this->assertFalse(Auth::check());
        //ログイン実行
        $response = $this->post('login', [
            'email'    => $this->user->email,
            'password' => 'password'
        ]);
        //認証されていることを確認
        $this->assertTrue(Auth::check());
    }
}
