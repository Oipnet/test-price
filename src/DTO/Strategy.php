<?php


namespace App\DTO;


class Strategy
{
    const SAME_AVERAGE = 0;
    const ALL_AVERAGE = 1;

    const STRATEGEES_LABELS = [
        'Meme état' => self::SAME_AVERAGE,
        'Tous les états' => self::ALL_AVERAGE
    ];
    const STRATEGIES = [self::SAME_AVERAGE, self::ALL_AVERAGE];
}
