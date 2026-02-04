<?php

namespace App\Enums;

enum SatuanEnum: string
{
    case PCS = 'pcs';
    case LUSIN = 'lusin';
    case KODI = 'kodi';
    case PASANG = 'pasang';
    case DUS = 'dus';

    public function label(): string
    {
        return match ($this) {
            self::PCS => 'Pcs',
            self::LUSIN => 'Lusin',
            self::KODI => 'Kodi',
            self::PASANG => 'Pasang',
            self::DUS => 'Dus',
        };
    }
}
