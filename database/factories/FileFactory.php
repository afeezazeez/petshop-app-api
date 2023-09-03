<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $size = ['MB', 'GB', 'KB', 'TB'];
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];


        return [
            'name' => fake()->text(7) . fake()->fileExtension(),
            'path' => fake()->filePath(),
            'size' => fake()->randomElement([1, 500]) . fake()->randomElement($size),
            'type' => fake()->randomElement($mimeTypes)

        ];
    }
}
