<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::factory()->create();
        $brand  = Brand::factory()->create();
        $file  = File::factory()->create();
        return [
            'category_uuid' => $category->uuid,
            'title' => fake()->text(10),
            'price' => fake()->randomFloat(2,100,1000),
            'description' => fake()->text(50),
            'metadata'  => [
                'brand' => $brand->uuid,
                'image' => $file-> uuid
            ]
        ];
    }
}
