<?php


namespace App\Contract;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

interface AmazonService
{
    public function getPricesByCondition(): Collection;
}
