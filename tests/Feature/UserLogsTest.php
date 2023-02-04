<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\LogActivity;
use Hash;
use Illuminate\Support\Facades\Auth;

class UserLogsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_logged_user_view_logs()
    {
        //create user
        $user = User::factory()->create(['date_of_birth' => '1996-10-16']);

        $this->post('custom-login',[
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $logs = LogActivity::first();
        $this->assertEquals(1,LogActivity::count());

        $user = Auth::user();
        $this->assertDatabaseHas('log_activity', [
            'subject' => 'User Login.',
            'user_id' => $user->id,
        ]);

        $response = $this->get('/viewlogs');
        $response->assertStatus(200);
    }
}
