<?php


namespace App\Service;


use App\Contract\AmazonService;
use App\DTO\Condition;
use App\DTO\Strategy;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class PriceComputerService
{
    /**
     * @var AmazonService
     */
    private $amazonService;

    public function __construct(AmazonService $amazonService)
    {
        $this->amazonService = $amazonService;
    }

    public function computePrice(int $condition, int $floorPrice, int $strategy): int
    {
        $competingBuisness = $this->amazonService->getPricesByCondition();
        $price = 0;

        if ($strategy == Strategy::SAME_AVERAGE) {
            $price = $this->computeCheapestForCondition($condition, $competingBuisness) - 1;
        } else {
            $price = $this->computeForAllConditions($condition, $competingBuisness) - 100;
        }

        return $price < $floorPrice ? $floorPrice : $price;
    }

    private function sortCompetingByPrice(array $competingBuisiness): Collection
    {
        $iterator = (new ArrayCollection($competingBuisiness))->getIterator();
        $iterator->uasort(function ($first, $second) {
            if ($first['price'] === $second['price']) {
                return 0;
            }

            return $first['price'] < $second['price'] ? -1 : 1;
        });

        return new ArrayCollection(iterator_to_array($iterator));
    }

    private function computeCheapestForCondition(int $condition, Collection $competingBuisness): int
    {
        if (! $competingBuisness->get($condition)) {
            return -1;
        }

        /** @var Collection $competingBuisnessForCondition */
        $competingBuisnessForCondition = $this->sortCompetingByPrice($competingBuisness->get($condition));

        return $competingBuisnessForCondition->first()['price'];
    }

    private function computeForAllConditions(int $condition, Collection $competingBuisness)
    {
        $currentConditionKey = array_search($condition, Condition::CONDITIONS);
        $betterConditions = array_filter(Condition::CONDITIONS, fn ($value, $key) => $key > $currentConditionKey, ARRAY_FILTER_USE_BOTH);

        $cheapestPrices = [];
        foreach ($betterConditions as $condition) {
            $cheapestPrices[] = $this->computeCheapestForCondition($condition, $competingBuisness);
        }
        $cheapestPrices = array_filter($cheapestPrices, fn($price) => $price >= 0);
        sort($cheapestPrices);

        return $cheapestPrices[0] ?? 0;
    }
}
