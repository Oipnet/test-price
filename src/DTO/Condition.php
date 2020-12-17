<?php


namespace App\DTO;


class Condition
{
    const AVERAGE = 0;
    const GOOD = 1;
    const VERY_GOOD = 2;
    const LIKE_NEW = 3;
    const NEW = 4;

    const CONDITIONS = [self::AVERAGE, self::GOOD, self::VERY_GOOD, self::LIKE_NEW, self::NEW];

    const CONNDITIONS_LABELS = [
        'Etat moyen' => self::AVERAGE,
        'Bon état' => self::GOOD,
        'Très bon état' => self::VERY_GOOD,
        'Comme neuf' => self::LIKE_NEW,
        'Neuf' => self::NEW
    ];
}
