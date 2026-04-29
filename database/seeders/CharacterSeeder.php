<?php

namespace Database\Seeders;

use App\Enums\AntiArchetype;
use App\Enums\Archetype;
use App\Models\Character;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    public function run(): void
    {
        $characters = [
            ['slug' => 'aki',     'name' => 'Aki',     'archetype' => Archetype::Unique,   'anti_archetype' => AntiArchetype::Grappler],
            ['slug' => 'akuma',   'name' => 'Akuma',   'archetype' => Archetype::Shoto,    'anti_archetype' => AntiArchetype::Unique],
            ['slug' => 'alex',    'name' => 'Alex',    'archetype' => Archetype::Grappler, 'anti_archetype' => AntiArchetype::Zoner],
            ['slug' => 'blanka',  'name' => 'Blanka',  'archetype' => Archetype::Unique,   'anti_archetype' => AntiArchetype::Grappler],
            ['slug' => 'bison',   'name' => 'Bison',   'archetype' => Archetype::Rushdown, 'anti_archetype' => AntiArchetype::Shoto],
            ['slug' => 'cammy',   'name' => 'Cammy',   'archetype' => Archetype::Rushdown, 'anti_archetype' => AntiArchetype::Shoto],
            ['slug' => 'chun_li', 'name' => 'Chun-Li', 'archetype' => Archetype::Rushdown, 'anti_archetype' => AntiArchetype::Shoto],
            ['slug' => 'c_viper', 'name' => 'C. Viper','archetype' => Archetype::Unique,   'anti_archetype' => AntiArchetype::Grappler],
            ['slug' => 'deeJay',  'name' => 'Dee Jay', 'archetype' => Archetype::Rushdown, 'anti_archetype' => AntiArchetype::Shoto],
            ['slug' => 'dhalsim', 'name' => 'Dhalsim', 'archetype' => Archetype::Zoner,    'anti_archetype' => AntiArchetype::Rushdown],
            ['slug' => 'ed',      'name' => 'Ed',      'archetype' => Archetype::Zoner,    'anti_archetype' => AntiArchetype::Rushdown],
            ['slug' => 'elena',   'name' => 'Elena',   'archetype' => Archetype::Shoto,    'anti_archetype' => AntiArchetype::Unique],
            ['slug' => 'guile',   'name' => 'Guile',   'archetype' => Archetype::Zoner,    'anti_archetype' => AntiArchetype::Rushdown],
            ['slug' => 'honda',   'name' => 'Honda',   'archetype' => Archetype::Rushdown, 'anti_archetype' => AntiArchetype::Shoto],
            ['slug' => 'jamie',   'name' => 'Jamie',   'archetype' => Archetype::Shoto,    'anti_archetype' => AntiArchetype::Unique],
            ['slug' => 'jp',      'name' => 'JP',      'archetype' => Archetype::Zoner,    'anti_archetype' => AntiArchetype::Rushdown],
            ['slug' => 'juri',    'name' => 'Juri',    'archetype' => Archetype::Shoto,    'anti_archetype' => AntiArchetype::Unique],
            ['slug' => 'ken',     'name' => 'Ken',     'archetype' => Archetype::Rushdown, 'anti_archetype' => AntiArchetype::Shoto],
            ['slug' => 'kimberly','name' => 'Kimberly','archetype' => Archetype::Rushdown, 'anti_archetype' => AntiArchetype::Shoto],
            ['slug' => 'lily',    'name' => 'Lily',    'archetype' => Archetype::Grappler, 'anti_archetype' => AntiArchetype::Zoner],
            ['slug' => 'luke',    'name' => 'Luke',    'archetype' => Archetype::Shoto,    'anti_archetype' => AntiArchetype::Unique],
            ['slug' => 'mai',     'name' => 'Mai',     'archetype' => Archetype::Rushdown, 'anti_archetype' => AntiArchetype::Shoto],
            ['slug' => 'manon',   'name' => 'Manon',   'archetype' => Archetype::Grappler, 'anti_archetype' => AntiArchetype::Zoner],
            ['slug' => 'marisa',  'name' => 'Marisa',  'archetype' => Archetype::Unique,   'anti_archetype' => AntiArchetype::Grappler],
            ['slug' => 'rashid',  'name' => 'Rashid',  'archetype' => Archetype::Shoto,    'anti_archetype' => AntiArchetype::Unique],
            ['slug' => 'ryu',     'name' => 'Ryu',     'archetype' => Archetype::Shoto,    'anti_archetype' => AntiArchetype::Unique],
            ['slug' => 'sagat',   'name' => 'Sagat',   'archetype' => Archetype::Shoto,    'anti_archetype' => AntiArchetype::Unique],
            ['slug' => 'terry',   'name' => 'Terry',   'archetype' => Archetype::Shoto,    'anti_archetype' => AntiArchetype::Unique],
            ['slug' => 'zangief', 'name' => 'Zangief', 'archetype' => Archetype::Grappler, 'anti_archetype' => AntiArchetype::Zoner],
        ];

        foreach ($characters as $data) {
            Character::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name'                => $data['name'],
                    'archetype'           => $data['archetype'],
                    'anti_archetype'      => $data['anti_archetype'],
                    'profile_picture_path'=> 'images/' . $data['slug'] . '.png',
                ]
            );
        }
    }
}
