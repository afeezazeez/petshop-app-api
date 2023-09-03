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

class AdminUserControllerTest extends TestCase
{
    use JwtTokenHelper, RefreshDatabase;

    protected User|null $user;
    protected string $token;
    protected User|null $normalUser;

    /**
     * @throws ClientErrorException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->user = User::where('is_admin', 1)->first() ?? null;
        $this->normalUser = User::where('is_admin', 0)->first() ?? null;
        $this->token = $this->generateToken($this->user);

    }

    /**
     * An admin who is logged in can fetch users
     */
    public function test_authenticated_admin_can_fetch_users(): void
    {
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token]);

        $response = $this->getJson(route('admin.user.list'));
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "current_page",
                "data",
                "first_page_url",
                "from",
                "last_page",
                "last_page_url",
                "links",
                "next_page_url",
                "path",
                "per_page",
                "prev_page_url",
                "to",
                "total"
            ]);
    }


    /**
     * An admin who is logged in can create admin
     */
    public function test_authenticated_admin_can_create_admin(): void
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
            'marketing' => '1',
        ];


        $response = $this->postJson(route('admin.user.create'), $userPayload);
        $response->assertStatus(Response::HTTP_OK);

    }

    /**
     * An admin who is logged in can update user
     */
    public function test_authenticated_admin_can_update_user(): void
    {
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token]);

        $userPayload = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'userpassword',
            'password_confirmation' => 'userpassword',
            'avatar' => 'ae631b1b-6124-4da3-8ea3-2e212a43834a',
            'address' => '123 Main Street',
            'phone_number' => '123-456-7890',
            'marketing' => '1',
        ];


        $response = $this->putJson(route('admin.user.update', ['uuid' => $this->normalUser->uuid ?? null]), $userPayload);
        $response->assertStatus(Response::HTTP_OK);

    }

}
