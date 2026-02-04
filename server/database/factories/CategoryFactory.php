<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Du lịch biển',
            'Du lịch núi',
            'Du lịch văn hóa',
            'Du lịch ẩm thực',
            'Du lịch mạo hiểm',
            'Du lịch sinh thái',
            'Du lịch thành phố',
            'Du lịch lịch sử'
        ];

        return [
            'category_name' => $this->faker->unique()->randomElement($categories),
            'description' => $this->faker->paragraph(2),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * Indicate that the category is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the category is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}