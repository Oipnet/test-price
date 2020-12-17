<?php


namespace App\Service;


use App\DTO\Condition;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class AmazonMockService implements \App\Contract\AmazonService
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function getPricesByCondition(): Collection
    {
        return new ArrayCollection($this->data);
    }
}
