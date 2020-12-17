<?php

namespace App\Controller;

use App\Service\PriceComputerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/compute", name="api_compute", methods={"POST"})
     */
    public function compute(Request $request, PriceComputerService $priceComputerService, ValidatorInterface $validator): Response
    {
        // TODO : Validate the request
        $condition = $request->get('condition');
        $strategy = $request->get('strategy');
        $floor = $request->get('floor');

        $price = $priceComputerService->computePrice($condition, $floor, $strategy);
        return $this->json(compact('price'));
    }
}
