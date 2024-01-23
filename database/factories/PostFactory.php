<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->title();
        $slug = Str::slug($title, '-');
        return [
            'user_id' => DB::table('users')->inRandomOrder()->value('id'),
            'title' => $title,
            'slug' => $slug,
            'description' => fake()->paragraph(),
            'is_published' => fake()->boolean()
        ];
    }
}
