<?php

namespace Database\Factories;

use App\Models\Tour;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    protected $model = Tour::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 week', '+2 months');
        $endDate = $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d H:i:s') . ' +2 weeks');

        return [
            'tour_name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->numberBetween(500000, 5000000),
            'duration' => $this->faker->numberBetween(1, 14),
            'max_participants' => $this->faker->numberBetween(5, 50),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => $this->faker->city() . ', ' . $this->faker->country(),
            'image' => null,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'category_id' => Category::factory(),
            'created_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the tour is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the tour is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the tour is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'start_date' => $this->faker->dateTimeBetween('-2 months', '-1 month'),
            'end_date' => $this->faker->dateTimeBetween('-1 month', '-1 week'),
        ]);
    }
}