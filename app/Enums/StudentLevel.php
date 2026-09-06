<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum StudentLevel: string implements HasLabel
{
    case Debutant = 'Débutant';

    case Intermediaire = 'Intermédiaire';

    case Avance = 'Avancé';

    case JeNeSaisPas = 'Je ne sais pas';

    public function getLabel(): string
    {
        return match ($this) {
            self::Debutant => 'مبتدئ',
            self::Intermediaire => 'متوسط',
            self::Avance => 'متقدم',
            self::JeNeSaisPas => 'لا أعرف',
        };
    }
}
