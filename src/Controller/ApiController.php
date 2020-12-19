<?php

namespace App\Controller;

use App\DTO\Condition;
use App\DTO\Strategy;
use App\Service\PriceComputerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/compute", name="api_compute", methods={"POST"})
     */
    public function compute(Request $request, PriceComputerService $priceComputerService, ValidatorInterface $validator): Response
    {
        $errors = $this->validateRequest($validator, $request);

        if ($errors) {
            return $this->json($errors, 400);
        }


        $condition = $request['condition'];
        $strategy = $request['strategy'];
        $floor = $request['floor'];

        $price = $priceComputerService->computePrice($condition, $floor, $strategy);

        return $this->json(compact('price'));
    }

    private function validateRequest(ValidatorInterface $validator, Request $request): ?array
    {
        $response = null;
        $request = json_decode($request->getContent(), true);

        $violations = $validator->validate($request['condition'] ?? '', [
            new Assert\NotBlank(),
            new Assert\Choice(Condition::CONDITIONS)
        ]);
        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $response['condition'][] = $violation->getMessage();
            }
        }

        $violations = $validator->validate($request['strategy'] ?? '', [
            new Assert\NotBlank(),
            new Assert\Choice(Strategy::STRATEGIES)
        ]);
        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $response['strategy'][] = $violation->getMessage();
            }
        }
        $violations = $validator->validate($request['floor'] ?? 0, [
            new Assert\Positive()
        ]);
        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $response['floor'][] = $violation->getMessage();
            }
        }

        return $response;
    }
}
