<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;

class UserPasswordTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_logged_user_change_password_view_load()
    {
        //create user
        $user = User::factory()->create(['date_of_birth' => '1996-10-16']);

        $this->post('custom-login',[
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        
        $response = $this->get('password');
        $response->assertStatus(200);
        $login_user = Auth::user();
        $this->assertEquals($user->email,$login_user->email);
    }

    public function test_a_logged_user_update_password()
    {
        //create user
        $user = User::factory()->create(['date_of_birth' => '1996-10-16']);

        $this->post('custom-login',[
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $post = Auth::user();
        $response = $this->post(route('password.update',$post->id),[
            'current-password' => 'password',
            'new-password' => '12345678',
            'new-password-confirm' => '12345678'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('dashboard');
    }
}
