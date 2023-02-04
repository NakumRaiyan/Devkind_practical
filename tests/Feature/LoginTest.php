<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_first_view_load()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_login_view_load()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_login_with_email_and_password()
    {
        //create user
        $user = User::factory()->create(['date_of_birth' => '1996-10-16']);
        $this->post('custom-login',[
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
    }

    public function test_login_user_load_dashboard()
    {
         //create user
         $user = User::factory()->create(['date_of_birth' => '1996-10-16']);
         $response = $this->from('login')->post('custom-login',[
             'email' => $user->email,
             'password' => 'password',
         ]);
         $this->assertAuthenticated();
         $response->assertStatus(302); //redirect check
         $response->assertRedirect('dashboard');
    }
}
