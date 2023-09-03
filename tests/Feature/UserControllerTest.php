<?php

namespace Tests\Feature;

use App\Exceptions\ClientErrorException;
use App\Models\User;
use App\Traits\JwtTokenHelper;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use JwtTokenHelper,RefreshDatabase;

    protected User|null $user;
    protected string $token;

    /**
     * @throws ClientErrorException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->user = User::where('is_admin',0)->first() ?? null;
        $this->token = $this->generateToken($this->user);

    }

    /**
     * A user can view profile
     */
    public function test_user_can_view_profile(): void
    {
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token]);

        $response = $this->getJson(route('user.show'));
        $response->assertStatus(Response::HTTP_OK);

    }


    /**
     * An admin who is logged in can create admin
     */
    public function test_user_can_create_account(): void
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

        $response = $this->postJson(route('user.create'),$userPayload);
        $response->assertStatus(Response::HTTP_OK);
        $responseContent = $response->getContent();
        if (is_string($responseContent) && is_array(json_decode($responseContent, true)) && json_last_error() === JSON_ERROR_NONE) {
            $responseData = json_decode($responseContent, true);
            $this->assertEquals($responseData['data']['email'],$userPayload['email']);
        }


    }



}
