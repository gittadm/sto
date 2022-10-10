<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'user_id' => 1,
            'commentable_type' => $this->faker->randomElement(Comment::getModelMapAliases()),
            'commentable_id' => 1
        ];
    }
}
