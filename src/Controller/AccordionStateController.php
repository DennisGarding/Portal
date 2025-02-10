<?php

namespace App\Controller;

use App\Entity\AccordionState;
use App\Repository\AccordionStateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccordionStateController extends AbstractController
{
    public function __construct(
        private readonly AccordionStateRepository $accordionStateRepository,
    )
    {

    }

    #[Route('/call/accordion/state/load', name: 'call_accordion_state_load', methods: ['GET'])]
    public function load(): JsonResponse
    {
        $state = $this->accordionStateRepository->find(1);
        if (!$state instanceof AccordionState) {
            $this->json(
                ['error' => 'Could not load accordionState'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->json($state->getState());
    }

    #[Route('/call/accordion/state/save', name: 'call_accordion_state_save', methods: ['POST'])]
    public function save(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $state = $this->accordionStateRepository->find(1);

        if (!$state instanceof AccordionState) {
            $this->json(
                ['error' => 'Could not load accordionState'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $state->setState(\json_decode($data['state'], true));

        $this->accordionStateRepository->save($state);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
