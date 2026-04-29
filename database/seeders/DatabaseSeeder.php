<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Strike;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Reference data: characters
            $this->call(CharacterSeeder::class);

            // Reference data: strikes
            DB::table('strikes')->insert([
                ['name' => 'Standing light punch',  'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Crouching medium punch', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Jumping heavy kick',    'created_at' => now(), 'updated_at' => now()],
            ]);

            // Users
            DB::table('users')->insert([
                'id'         => 1,
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'username'   => 'johndoe',
                'email'      => 'john.doe@example.com',
                'password'   => Hash::make('password'),
                'created_at' => new \DateTime('2026-02-09 10:00:00'),
                'updated_at' => new \DateTime('2026-02-09 10:00:00'),
            ]);

            DB::table('users')->insert([
                'id'         => 2,
                'first_name' => 'Jane',
                'last_name'  => 'Doe',
                'username'   => 'janedoe',
                'email'      => 'jane.doe@example.com',
                'password'   => Hash::make('password'),
                'created_at' => new \DateTime('2026-02-09 11:00:00'),
                'updated_at' => new \DateTime('2026-02-09 11:00:00'),
            ]);

            // Resolve reference IDs
            $user    = User::first();
            $aki     = Character::where('slug', 'aki')->first();
            $zangief = Character::where('slug', 'zangief')->first();
            $sagat   = Character::where('slug', 'sagat')->first();
            $slp     = Strike::where('name', 'Standing light punch')->first();
            $cmp     = Strike::where('name', 'Crouching medium punch')->first();
            $jhk     = Strike::where('name', 'Jumping heavy kick')->first();

            // Moves (posts)
            DB::table('moves')->insert([
                [
                    'user_id'      => $user->id,
                    'strike_id'    => $slp->id,
                    'character_id' => $aki->id,
                    'title'        => 'Standing light punch — Aki',
                    'content'      => 'Standing light punch performed by Aki.',
                    'created_at'   => new \DateTime('2026-02-09 12:00:00'),
                    'updated_at'   => new \DateTime('2026-02-09 12:00:00'),
                ],
                [
                    'user_id'      => $user->id,
                    'strike_id'    => $cmp->id,
                    'character_id' => $zangief->id,
                    'title'        => 'Crouching medium punch — Zangief',
                    'content'      => 'Crouching medium punch performed by Zangief.',
                    'created_at'   => new \DateTime('2026-02-09 12:05:00'),
                    'updated_at'   => new \DateTime('2026-02-09 12:05:00'),
                ],
                [
                    'user_id'      => $user->id,
                    'strike_id'    => $jhk->id,
                    'character_id' => $sagat->id,
                    'title'        => 'Jumping heavy kick — Sagat',
                    'content'      => 'Jumping heavy kick performed by Sagat.',
                    'created_at'   => new \DateTime('2026-02-09 12:10:00'),
                    'updated_at'   => new \DateTime('2026-02-09 12:10:00'),
                ],
            ]);
        });
    }
}
