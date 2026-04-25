<?php

namespace App\Models;

use App\Enums\Archetype;
use App\Enums\AntiArchetype;

class Character
{
    private static function resolveAntiArchetype(Archetype $archetype): AntiArchetype
    {
        return match ($archetype) {
            Archetype::Shoto    => AntiArchetype::Unique,
            Archetype::Unique   => AntiArchetype::Grappler,
            Archetype::Grappler => AntiArchetype::Zoner,
            Archetype::Zoner    => AntiArchetype::Rushdown,
            Archetype::Rushdown => AntiArchetype::Shoto,
        };
    }

    private static function make(string $name, string $slug, Archetype $archetype): object
    {
        return (object) [
            'name'                => $name,
            'slug'                => $slug,
            'archetype'           => $archetype,
            'anti_archetype'      => self::resolveAntiArchetype($archetype),
            'profile_picture_path' => "images/{$slug}.png",
        ];
    }

    public static function all(): array
    {
        return [
            self::make('Akuma',   'akuma',   Archetype::Shoto),
            self::make('Elena',   'elena',   Archetype::Shoto),
            self::make('Jamie',   'jamie',   Archetype::Shoto),
            self::make('Juri',    'juri',    Archetype::Shoto),
            self::make('Luke',    'luke',    Archetype::Shoto),
            self::make('Rashid',  'rashid',  Archetype::Shoto),
            self::make('Ryu',     'ryu',     Archetype::Shoto),
            self::make('Sagat',   'sagat',   Archetype::Shoto),
            self::make('Terry',   'terry',   Archetype::Shoto),

            self::make('Cammy',    'cammy',    Archetype::Rushdown),
            self::make('Chun-Li',  'chun_li',  Archetype::Rushdown),
            self::make('Deejay',   'deejay',   Archetype::Rushdown),
            self::make('Honda',    'honda',    Archetype::Rushdown),
            self::make('Ken',      'ken',      Archetype::Rushdown),
            self::make('Kimberly', 'kimberly', Archetype::Rushdown),
            self::make('Bison',    'bison',    Archetype::Rushdown),

            self::make('Dhalsim', 'dhalsim', Archetype::Zoner),
            self::make('Ed',      'ed',      Archetype::Zoner),
            self::make('Guile',   'guile',   Archetype::Zoner),
            self::make('JP',      'jp',      Archetype::Zoner),

            self::make('Alex',    'alex',    Archetype::Grappler),
            self::make('Lily',    'lily',    Archetype::Grappler),
            self::make('Manon',   'manon',   Archetype::Grappler),
            self::make('Zangief', 'zangief', Archetype::Grappler),

            self::make('Aki',     'aki',     Archetype::Unique),
            self::make('Blanka',  'blanka',  Archetype::Unique),
            self::make('C.Viper', 'c_viper', Archetype::Unique),
            self::make('Marisa',  'marisa',  Archetype::Unique),
        ];
    }

    public static function findBySlug(string $slug): ?object
    {
        foreach (self::all() as $character) {
            if ($character->slug === $slug) {
                return $character;
            }
        }
        return null;
    }
}
