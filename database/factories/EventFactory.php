<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Event;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Event::class;
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->realText(),
            'thumbnail' => $this->faker->realText(),
            'number_of_applicants' => $this->faker->randomNumber(2),
            'event_date' => date('Y-m-d H:i:s'),
            'area_id' => $this->faker->randomNumber(1),
            'post_code' => $this->faker->regexify('[1-9]{3}-[0-9]{4}'),
            'address' => $this->faker->realText(),
            'other_address' => $this->faker->realText(),
            'event_start' => date('Y-m-d H:i:s'),
            'event_end' => date('Y-m-d H:i:s'),
            'recruit_start' => date('Y-m-d H:i:s'),
            'recruit_end' => date('Y-m-d H:i:s'),
            'overview' => $this->faker->realText(),
            'theme' => $this->faker->realText(),
            'email' => $this->faker->safeEmail(),
            'event_display' => $this->faker->boolean,
            'event_tags' => array(1,2,3),
            'recommendation' => $this->faker->realText(),
            'notes' => $this->faker->realText(),
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }
}
