<?php

declare(strict_types=1);

namespace App\DataSources\Data;

interface VeekunDataMapping
{
    public const STATS = [
        1 => "hp",
        2 => "atk",
        3 => "def",
        4 => "spa",
        5 => "spd",
        6 => "spe",
        7 => "acc",
        8 => "eva",
    ];

    public const SHAPES = [
        1  => "head", // ball
        2  => "serpentine", // squiggle
        3  => "fins", // fish
        4  => "head-arms", // arms
        5  => "head-base", // blob
        6  => "bipedal-tailed", // upright
        7  => "head-legs", // legs
        8  => "quadruped",
        9  => "wings-single", // wings  (single pair)
        10 => "tentacles", // (or multiped body)
        11 => "multiple", // heads (multiple entities or bodies)
        12 => "bipedal-tailless", // humanoid
        13 => "wings-multiple", // bug-wings  (multiple pairs)
        14 => "insectoid", // armor
    ];

    public const GROWTH_RATES = [
        1 => "slow",
        2 => "medium-fast", // medium
        3 => "fast",
        4 => "medium-slow",
        5 => "erratic", // slow-then-very-fast
        6 => "fluctuating", // fast-then-very-slow
    ];

    public const POKEMON_SLUGS = [
        'raticate-totem-alola'    => 'raticate-alola-totem',
        "pikachu-original-cap"    => "pikachu-original",
        "pikachu-hoenn-cap"       => "pikachu-hoenn",
        "pikachu-sinnoh-cap"      => "pikachu-sinnoh",
        "pikachu-unova-cap"       => "pikachu-unova",
        "pikachu-kalos-cap"       => "pikachu-kalos",
        "pikachu-alola-cap"       => "pikachu-alola",
        "pikachu-partner-cap"     => "pikachu-partner",
        "marowak-totem"           => "marowak-alola-totem",
        "deoxys-normal"           => "deoxys",
        "wormadam-plant"          => "wormadam",
        "giratina-altered"        => "giratina",
        "shaymin-land"            => "shaymin",
        "basculin-red-striped"    => "basculin",
        "darmanitan-standard"     => "darmanitan",
        "tornadus-incarnate"      => "tornadus",
        "thundurus-incarnate"     => "thundurus",
        "landorus-incarnate"      => "landorus",
        "keldeo-ordinary"         => "keldeo",
        "meloetta-aria"           => "meloetta",
        "meowstic-male"           => "meowstic",
        "meowstic-female"         => "meowstic",
        "aegislash-shield"        => "aegislash",
        "pumpkaboo-average"       => "pumpkaboo",
        "gourgeist-average"       => "gourgeist",
        "zygarde-50"              => "zygarde",
        "oricorio-baile"          => "oricorio",
        "lycanroc-midday"         => "lycanroc",
        "wishiwashi-solo"         => "wishiwashi",
        "minior-red-meteor"       => "minior-meteor",
        "minior-orange-meteor"    => "minior-meteor",
        "minior-yellow-meteor"    => "minior-meteor",
        "minior-green-meteor"     => "minior-meteor",
        "minior-blue-meteor"      => "minior-meteor",
        "minior-indigo-meteor"    => "minior-meteor",
        "minior-violet-meteor"    => "minior-meteor",
        "minior-red"              => "minior",
        "mimikyu-disguised"       => "mimikyu",
        "mimikyu-totem-disguised" => "mimikyu-totem",
        "mimikyu-totem-busted"    => "mimikyu-busted-totem",
        "necrozma-dusk"           => "necrozma-dusk-mane",
        "necrozma-dawn"           => "necrozma-dawn-wings",
        "unown-a"                 => "unown",
        'burmy-plant'             => 'burmy',
        'mothim-plant'            => 'mothim',
        'mothim-sandy'            => 'mothim',
        'mothim-trash'            => 'mothim',
        'cherrim-overcast'        => 'cherrim',
        "shellos-west"            => "shellos",
        "gastrodon-west"          => "gastrodon",
        "arceus-normal"           => "arceus",
        "arceus-unknown"          => "arceus",
        "deerling-spring"         => "deerling",
        "sawsbuck-spring"         => "sawsbuck",
        "scatterbug-icy-snow"     => "scatterbug",
        "scatterbug-polar"        => "scatterbug",
        "scatterbug-tundra"       => "scatterbug",
        "scatterbug-continental"  => "scatterbug",
        "scatterbug-garden"       => "scatterbug",
        "scatterbug-elegant"      => "scatterbug",
        "scatterbug-meadow"       => "scatterbug",
        "scatterbug-modern"       => "scatterbug",
        "scatterbug-marine"       => "scatterbug",
        "scatterbug-archipelago"  => "scatterbug",
        "scatterbug-high-plains"  => "scatterbug",
        "scatterbug-sandstorm"    => "scatterbug",
        "scatterbug-river"        => "scatterbug",
        "scatterbug-monsoon"      => "scatterbug",
        "scatterbug-savanna"      => "scatterbug",
        "scatterbug-sun"          => "scatterbug",
        "scatterbug-ocean"        => "scatterbug",
        "scatterbug-jungle"       => "scatterbug",
        "scatterbug-fancy"        => "scatterbug",
        "scatterbug-poke-ball"    => "scatterbug",
        "spewpa-icy-snow"         => "spewpa",
        "spewpa-polar"            => "spewpa",
        "spewpa-tundra"           => "spewpa",
        "spewpa-continental"      => "spewpa",
        "spewpa-garden"           => "spewpa",
        "spewpa-elegant"          => "spewpa",
        "spewpa-meadow"           => "spewpa",
        "spewpa-modern"           => "spewpa",
        "spewpa-marine"           => "spewpa",
        "spewpa-archipelago"      => "spewpa",
        "spewpa-high-plains"      => "spewpa",
        "spewpa-sandstorm"        => "spewpa",
        "spewpa-river"            => "spewpa",
        "spewpa-monsoon"          => "spewpa",
        "spewpa-savanna"          => "spewpa",
        "spewpa-sun"              => "spewpa",
        "spewpa-ocean"            => "spewpa",
        "spewpa-jungle"           => "spewpa",
        "spewpa-fancy"            => "spewpa",
        "spewpa-poke-ball"        => "spewpa",
        "vivillon-icy-snow"       => "vivillon",
        "vivillon-poke-ball"      => "vivillon-pokeball",
        "flabebe-red"             => "flabebe",
        "floette-red"             => "floette",
        "florges-red"             => "florges",
        "furfrou-natural"         => "furfrou",
        "xerneas-neutral"         => "xerneas",
        "silvally-normal"         => "silvally",
    ];
}
