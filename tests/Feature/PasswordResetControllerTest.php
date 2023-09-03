<?php

namespace Tests\Feature;

use App\Exceptions\ClientErrorException;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PasswordResetControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User|null $user;

    /**
     * @throws ClientErrorException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->user = User::where('is_admin',0)->first() ?? null;

    }


    /**
     * A user can generate password reset token
     */
    public function test_user_can_generate_password_reset_token(): void
    {
        $payload = ['email'=>$this->user->email];
        $response = $this->postJson(route('user.forgot-password'),$payload);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * A user can generate password reset token and reset password
     */
    public function test_user_can_generate_password_reset_token_and_reset_password(): void
    {
        $payload = ['email'=>$this->user->email];
        $response = $this->postJson(route('user.forgot-password'),$payload);
        $response->assertOk();
        $responseContent = $response->getContent();
        if (is_string($responseContent) && is_array(json_decode($responseContent, true)) && json_last_error() === JSON_ERROR_NONE) {
            $responseData = json_decode($responseContent, true);
            $token = $responseData['data']['reset_token'];
            $payload = [
                'token' => $token,
                'email' => $this->user->email,
                'password' => 'userpassword',
                'password_confirmation' => 'userpassword'
            ];
            $resetRequest = $this->postJson(route('user.password-reset'),$payload);
            $resetRequest->assertOk();
        }

    }

}
