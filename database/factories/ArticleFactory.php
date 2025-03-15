<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => 1,
            'user_id' => 1,
            'title' => $title = fake()->text(15),
            'slug'  => str()->slug($title),
            'description' => fake()->text(200),
            'created_at' => now()
        ];
    }
}
