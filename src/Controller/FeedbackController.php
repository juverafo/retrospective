<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Repository\FeedbackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    #[Route('/api/feedback', methods: ['POST'])]
    public function createFeedback(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $feedback = new Feedback();
        $feedback->setType($data['type']);
        $feedback->setContent($data['content']);
        $feedback->setCreatedAt(new \DateTimeImmutable());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($feedback);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Feedback créé!'], Response::HTTP_CREATED);
    }

    #[Route('/api/feedback', methods: ['GET'])]
    public function getFeedbacks(FeedbackRepository $feedbackRepository): JsonResponse
    {
        $feedbacks = $feedbackRepository->findAll();
        $data = [];

        foreach ($feedbacks as $feedback) {
            $data[] = [
                'type' => $feedback->getType(),
                'content' => $feedback->getContent(),
                'createdAt' => $feedback->getCreatedAt()->format('Y-m-d'),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
