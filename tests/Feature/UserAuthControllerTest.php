<?php

namespace Tests\Feature;

use App\Models\User;
use App\Traits\JwtTokenHelper;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserAuthControllerTest extends TestCase
{
    use JwtTokenHelper,RefreshDatabase;

    protected User|null $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->user = User::where('is_admin',0)->first() ?? null;

    }

    /**
     * A user can login with valid credenctials
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        $data = [
            'email' => $this->user->email ?? null,
            'password' => 'userpassword'
        ];
        $response = $this->postJson(route('user.login'),$data);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'token',
                ],
                'error',
                'errors',
                'extra',
            ]);
    }

    /**
     * A user cannot login with invalid password
     */
    public function test_user_cannot_login_with_invalid_password(): void
    {
        $data = [
            'email' => $this->user->email ?? null,
            'password' => 'user'
        ];
        $response = $this->postJson(route('user.login'),$data);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $responseContent = $response->getContent();
        if (is_string($responseContent) && is_array(json_decode($responseContent, true)) && json_last_error() === JSON_ERROR_NONE) {
            $responseData = json_decode($responseContent, true);

            $this->assertEquals($responseData, [
                "success" => 0,
                "data" => [],
                "error" => "Incorrect password!",
                "errors" => [],
                "trace" => []
            ]);
        }


    }

    /**
     * A user cannot login with invalid email
     */
    public function test_user_cannot_login_with_invalid_email(): void
    {
        $data = [
            'email' => 'xyudd@dd.com',
            'password' => 'adminefefefef'
        ];
        $response = $this->postJson(route('user.login'),$data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                "success" => 0,
                "data" => [],
                "error" => "Failed validation",
                "errors" => [
                    "email" => [
                        "This email is not associated with any user"
                    ]
                ],
                "trace" => []
            ]);
    }
}
