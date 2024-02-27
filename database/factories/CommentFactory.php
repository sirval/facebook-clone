<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $commentableType = fake()->randomElement(['App\Models\Post', 'App\Models\Comment']);
        $commentableId  = $commentableType === 'App\Models\Post' 
                        ? Post::factory() 
                        : Comment::factory(); // Associate with either a post or comment content
    
        return [
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'commentable_id' => $commentableId,
            'commentable_type' => $commentableType,
            'content' => fake()->sentence(2)
        ];
    }
}
