<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Hash;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_registration_view_load()
    {
        $response = $this->get('/registration');
        $response->assertStatus(200);
    }

    public function test_register_user_with_data_and_check_with_count()
    {
        $this->post('custom-registration',[
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
            'date_of_birth' => '1990-10-25'
        ]);
        $this->assertEquals(1,User::count());
        $user = User::first();
        $this->assertEquals($user->name,'test');
    }

    public function test_register_user_with_data_and_check_with_email()
    {
        $this->post('custom-registration',[
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
            'date_of_birth' => '1990-10-25'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com',
        ]);
    }
}
