<?php

namespace Database\Factories;

use App\Core\Models\Content;
use App\Core\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Content::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = ['master', 'feed', 'featured'];
        shuffle($type);
        return [
            'content' => $this->faker->realText(),
            'title' => $this->faker->words(3, true),
            'category_id' => null,
            'thumbnail' => $this->faker->imageUrl(),
            'attach' => null,
            'type' => $type[0],
            'user_id' => User::first()->id,
        ];
    }
}
