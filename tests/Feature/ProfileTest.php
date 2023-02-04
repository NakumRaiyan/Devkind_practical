<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use Hash;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_logged_user_profile_view_load()
    {
        //create user
        $user = User::factory()->create(['date_of_birth' => '1996-10-16']);

        $this->post('custom-login',[
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response = $this->get('profile');
        $response->assertStatus(200);
        $login_user = Auth::user();
        $this->assertEquals($user->email,$login_user->email);
    }

    public function test_a_logged_user_profile_update()
    {
        //create user
        $user = User::factory()->create(['date_of_birth' => '1996-10-16']);

        $this->post('custom-login',[
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        
        $post = User::first();
        $response = $this->post(route('profile.update',$post->id),[
            'name' => 'Update test',
            'email' => 'updatetest@gmail.com',
            'date_of_birth' => '1990-10-25'
        ]);
        $update_user = User::first();
        $this->assertEquals('Update test',$update_user->name);
        $this->assertEquals('updatetest@gmail.com',$update_user->email);
        $this->assertEquals('1990-10-25',$update_user->date_of_birth);
        $this->assertDatabaseHas('users', [
            'email' => 'updatetest@gmail.com',
        ]);
    }
}
