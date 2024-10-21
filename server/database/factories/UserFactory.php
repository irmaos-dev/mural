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
            'username' => $this->faker->unique()->userName(),
            'email'    => $this->faker->unique()->safeEmail(),
            'bio'      => $this->faker->optional()->paragraph(),
            'image'    => $this->faker->optional()->imageUrl(),
            // 'password'   => 'password',
            'google_id'            => $this->faker->unique()->uuid(),
            'google_token'         => $this->faker->unique()->text(40),
            'google_refresh_token' => $this->faker->unique()->text(40),
            'created_at'           => $createdAt = $this->faker->dateTimeThisDecade(),
            'updated_at'           => $this->faker->optional(50, $createdAt)
                ->dateTimeBetween($createdAt),
        ];
    }
}
