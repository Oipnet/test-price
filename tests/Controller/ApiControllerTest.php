<?php


namespace App\Tests\Controller;


use App\DTO\Condition;
use App\DTO\Strategy;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    /**
     * @test
     * @dataProvider provideRequest
     */
    public function it_should_return_a_validation_error_if_all_field_are_not_defined($request, $code, $message)
    {
        $client = static::createClient();
        $client->request('POST', '/api/compute', [],[],['CONTENT_TYPE' => 'application/json'],json_encode($request));
        $this->assertEquals($code, $client->getResponse()->getStatusCode());
        $this->assertEquals($message, json_decode($client->getResponse()->getContent(), true));
    }

    public function provideRequest()
    {
        return [
            [
                [],
                400,
                [
                    "condition" => [
                        "This value should not be blank.",
                        "The value you selected is not a valid choice.",
                    ],
                    "strategy" => [
                        "This value should not be blank.",
                        "The value you selected is not a valid choice.",
                    ],
                    "floor" => [
                        "This value should be positive.",
                    ]
                ]
            ],
            [
                [ 'condition' => 99],
                400,
                [
                    "condition" => [
                        "The value you selected is not a valid choice.",
                    ],
                    "strategy" => [
                        "This value should not be blank.",
                        "The value you selected is not a valid choice.",
                    ],
                    "floor" => [
                        "This value should be positive.",
                    ]
                ]
            ],
            [
                [ 'strategy' => 99],
                400,
                [
                    "condition" => [
                        "This value should not be blank.",
                        "The value you selected is not a valid choice.",
                    ],
                    "strategy" => [
                        "The value you selected is not a valid choice.",
                    ],
                    "floor" => [
                        "This value should be positive.",
                    ]
                ]
            ],
            [
                [ 'condition' => Condition::AVERAGE, 'strategy' => Strategy::SAME_AVERAGE, 'floor' => -5],
                400,
                [
                    "floor" => [
                        "This value should be positive.",
                    ]
                ]
            ]
        ];
    }
}
