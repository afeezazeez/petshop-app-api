<?php
// tests/Unit/UserTest.php
namespace Tests\Unit;

use App\Exceptions\ClientErrorException;
use App\Models\Category;
use App\Traits\JwtTokenHelper;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class JwtTokenTest extends TestCase
{
    use RefreshDatabase,JwtTokenHelper;

    protected User|null $user;

    /**
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->user = User::where('is_admin',1)->first() ?? null;

    }

    /**
     * Test if a jwt token can be created
     *
     * @return void
     */
    public function testThatJwtCanBeCreated(): void
    {
        $token = $this->generateToken($this->user);

        $this->assertNotEmpty($token);

        $this->assertIsString($token);

    }
}
