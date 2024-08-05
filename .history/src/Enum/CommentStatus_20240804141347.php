<?php

namespace App\Enum;

enum BookStatus: string
{
    case Pending = 'pending';
    case Published = 'published';
    case Moderated = 'moderated';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'En attente',
            self::Published => 'Publié',
            self::Moderated => 'Modifié',
        };
    }
}
