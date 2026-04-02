<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reaction;
use App\Models\Idea;
use App\Models\User;

class ReactionSeeder extends Seeder
{
    public function run(): void
    {
        $ideaIds = Idea::pluck('ideaId')->toArray();
        $userIds = User::pluck('userId')->toArray();

        if (empty($ideaIds) || empty($userIds)) {
            return;
        }

        foreach ($ideaIds as $ideaId) {
            // Lấy ngẫu nhiên từ 2 đến 5 người dùng để vote cho bài này
            $voterCount = rand(2, min(5, count($userIds)));
            $voters = (array) array_rand(array_flip($userIds), $voterCount);

            foreach ($voters as $voterId) {
                Reaction::create([
                    'ideaId' => $ideaId,
                    'userId' => $voterId,
                    // Random 70% cơ hội là Upvote (true), 30% là Downvote (false)
                    'is_upvote' => (rand(1, 10) <= 7)
                ]);
            }
        }
    }
}
