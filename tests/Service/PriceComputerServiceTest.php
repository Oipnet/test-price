<?php


namespace App\Tests\Service;


use App\DTO\Condition;
use App\DTO\Strategy;
use App\Service\AmazonMockService;
use App\Service\PriceComputerService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class PriceComputerServiceTest extends TestCase
{
/*
[
Average::AVERAGE_CONDITION => [
['seller' => 'Abc jeux', 'price' => 1410],
['seller' => 'Games-planet', 'price' => 1620],
],
Average::AVERAGE_GOOD => [
['seller' => 'Media-games', 'price' => 1800],
['seller' => 'Tous-les-jeux', 'price' => 2444],
],
Average::AVERAGE_VERY_GOOD => [
['seller' => 'Micro-jeux', 'price' => 2000],
['seller' => 'Top-Jeux-video', 'price' => 2150]
],
Average::AVERAGE_LIKE_NEW => [
['seller' => 'Diffusion-133', 'price' => 2900],
],
Average::AVERAGE_NEW => [
['seller' => 'France-video', 'price' => 3099]
]
]*/
    /**
     * @test
     */
    public function it_should_compute_return_1409_when_strategy_is_same_condition_and_cheapest_is_1410_and_floor_is_1000() {
        $data = [
            Condition::AVERAGE => [
                'Games-planet' => ['price' => 1620],
                'Abc jeux' => ['price' => 1410],
            ]
        ];

        $priceComputer = new PriceComputerService(new AmazonMockService($data));

        $price = $priceComputer->computePrice(Condition::AVERAGE, 1000, Strategy::SAME_AVERAGE);
        $this->assertEquals(1409, $price);
    }

    /**
     * @test
     */
    public function it_should_compute_return_1600_when_strategy_is_same_condition_and_cheapest_is_1410_and_floor_is_1600() {
        $data = [
            Condition::AVERAGE => [
                'Abc jeux' => ['price' => 1410],
                'Games-planet' => ['price' => 1620],
            ]
        ];

        $priceComputer = new PriceComputerService(new AmazonMockService($data));

        $price = $priceComputer->computePrice(Condition::AVERAGE, 1600, Strategy::SAME_AVERAGE);
        $this->assertEquals(1600, $price);
    }

    /**
     * @test
     */
    public function it_should_compute_return_1100_when_strategy_is_all_condition_and_cheapest_better_average_is_1200_and_floor_is_1000() {
        $data = [
            Condition::AVERAGE => [
                'Abc jeux' => ['price' => 1100],
                'Games-planet' => ['price' => 1620],
            ],
            Condition::GOOD => [
                'Abc jeux' => ['price' => 1500],
                'Games-planet' => ['price' => 1800],
            ],
            Condition::LIKE_NEW => [
                'Abc jeux' => ['price' => 2000],
                'Games-planet' => ['price' => 1800],
            ],
            Condition::NEW => [
                'Abc jeux' => ['price' => 1200],
                'Games-planet' => ['price' => 2000],
            ],
        ];

        $priceComputer = new PriceComputerService(new AmazonMockService($data));

        $price = $priceComputer->computePrice(Condition::GOOD, 1000, Strategy::ALL_AVERAGE);
        $this->assertEquals(1100, $price);
    }
}
