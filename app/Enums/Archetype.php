<?php

namespace App\Enums;

enum Archetype: string
{
    case Shoto = 'shoto';
    case Rushdown = 'rushdown';
    case Zoner = 'zoner';
    case Grappler = 'grappler';
    case Unique = 'unique';
}
