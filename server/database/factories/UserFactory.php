<?php

declare(strict_types = 1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
final class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            // 'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'bio'   => $this->faker->optional()->paragraph(),
            'image' => $this->faker->optional()->imageUrl(),
            // 'password'   => 'password',
            'google_id'            => $this->faker->unique()->userName(),
            'google_token'         => $this->faker->unique()->userName(),
            'google_refresh_token' => $this->faker->unique()->userName(),
            'created_at'           => $createdAt = $this->faker->dateTimeThisDecade(),
            'updated_at'           => $this->faker->optional(50, $createdAt)
                ->dateTimeBetween($createdAt),
        ];
    }
}
