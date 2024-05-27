<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tasks>
 */
class TasksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['ongoing', 'done', 'submitted']);
        return
            [
                "user_id" => User::factory(),
                "title" => $this->faker->title(),
                "description" => $this->faker->text(),
                "status" => $status,
                "added_date" => $this->faker->dateTimeThisDecade(),
                "finished_date" => $status == 'submitted' ? $this->faker->dateTimeThisDecade() : NULL,
            ];
    }
}
