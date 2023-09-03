<?php
// tests/Unit/UserTest.php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test if a user can be created and saved to the database.
     *
     * @return void
     */
    public function testUserCanBeCreated(): void
    {

        $userPayload = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'userpassword',
            'password_confirmation' => 'userpassword',
            'avatar' => 'ae631b1b-6124-4da3-8ea3-2e212a43834a',
            'address' => '123 Main Street',
            'phone_number' => '123-456-7890',
            'is_marketing' => '1',
        ];
        $user = User::create($userPayload);

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com',
        ]);

        $this->assertEquals('johndoe@example.com', $user->email);

    }
}
