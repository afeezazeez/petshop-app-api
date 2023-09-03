<?php
// tests/Unit/UserTest.php
namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CategoryTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test if a category can be created and saved to the database.
     *
     * @return void
     */
    public function testCategoryCanBeCreated(): void
    {

        $category = Category::create(['title' => 'Electronics', 'slug' => 'electronic-appliances']);

        $this->assertDatabaseHas('categories', [
            'title' => 'Electronics',
            'slug' => 'electronic-appliances'
        ]);

        $this->assertEquals('electronic-appliances', $category->slug);

    }
}
