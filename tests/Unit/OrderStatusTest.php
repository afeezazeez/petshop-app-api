<?php
// tests/Unit/UserTest.php
namespace Tests\Unit;

use App\Models\Category;
use App\Models\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class OrderStatusTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test if  order status can be created and saved to the database.
     *
     * @return void
     */
    public function testOrderStatusCanBeCreated(): void
    {

        $order_status = OrderStatus::create(['title'=>'shipped']);

        $this->assertDatabaseHas('order_statuses', [
            'title' => 'shipped'
        ]);

        $this->assertEquals('shipped', $order_status->title);

    }
}
