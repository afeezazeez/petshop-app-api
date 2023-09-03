<?php

namespace Tests\Feature;

use App\Exceptions\ClientErrorException;
use App\Models\User;
use App\Traits\JwtTokenHelper;
use Database\Seeders\OrderSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class OrderControllerTest extends TestCase
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
        $this->seed(OrderSeeder::class);
        $this->user = User::where('is_admin', 0)
            ->whereHas('orders')
            ->first() ?? null;
        $this->token = $this->generateToken($this->user);

    }

    /**
     * An authenticated user can view orders profile
     */
    public function test_user_can_view_profile(): void
    {
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token]);

        $response = $this->getJson(route('user.orders'));
        $response->assertStatus(Response::HTTP_OK);

    }



}
