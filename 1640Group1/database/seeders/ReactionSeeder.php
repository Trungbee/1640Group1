<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reaction;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        DB::statement('TRUNCATE TABLE reactions RESTART IDENTITY CASCADE');


        $ideaIds = Idea::pluck('ideaId')->toArray();
        $userIds = User::pluck('userId')->toArray();
        $totalUsers = count($userIds);


        if (empty($ideaIds) || $totalUsers === 0) {
            $this->command->warn('No Ideas or Users found in database. Please seed them first.');
            return;
        }

        $this->command->info("Starting to seed reactions for $totalUsers users...");

        foreach ($ideaIds as $ideaId) {

            $minVoters = 1;
            $maxVoters = min(25, $totalUsers);

            $voterCount = rand($minVoters, $maxVoters);


            $randomKeys = array_rand(array_flip($userIds), $voterCount);


            $voterIds = is_array($randomKeys) ? $randomKeys : [$randomKeys];

            foreach ($voterIds as $voterId) {
                Reaction::create([
                    'ideaId'    => $ideaId,
                    'userId'    => $voterId,

                    'is_upvote' => (rand(1, 10) <= 8)
                ]);
            }
        }

        $this->command->info("Success! ReactionSeeder has finished seeding.");
    }
}
