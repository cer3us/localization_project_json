<?php

namespace App\Enums;

enum ProgressStatus: string
{
    case CREATED = 'created';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public static function fromProgress(float $progress): self
    {
        return match (true) {
            $progress == 0 => self::CREATED,
            $progress < 100 => self::IN_PROGRESS,
            default => self::COMPLETED,
        };
    }
}
