<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $likeableType = fake()->randomElement(['App\Models\Post', 'App\Models\Comment']);
        $likeableId  = $likeableType === 'App\Models\Post' 
                        ? Post::factory() 
                        : Comment::factory(); // Associate with either a post or comment like
    
        return [
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'likeable_id' => $likeableId,
            'likeable_type' => $likeableType,
        ];
    }
}
