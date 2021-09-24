<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\Region;

interface RegionEnum
{
    public const KANTO = 'kanto';
    public const JOHTO = 'johto';
    public const HOENN = 'hoenn';
    public const SINNOH = 'sinnoh';
    public const UNOVA = 'unova';
    public const KALOS = 'kalos';
    public const ALOLA = 'alola';
    public const GALAR = 'galar';
    public const HISUI = 'hisui';
    public const ALL = [
        self::KALOS,
        self::JOHTO,
        self::HOENN,
        self::SINNOH,
        self::UNOVA,
        self::KALOS,
        self::ALOLA,
        self::GALAR,
        self::HISUI,
    ];
}
