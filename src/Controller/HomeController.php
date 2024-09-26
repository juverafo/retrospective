<?php

namespace App\Controller;

use App\Repository\FeedbackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(FeedbackRepository $feedbackRepository): Response
    {
        $feedbacks = $feedbackRepository->findAll();

        $formattedFeedbacks = array_map(static function($feedback) {
            return [
                'id' => $feedback->getId(),
                'type' => $feedback->getType(),
                'feedback' => $feedback->getContent(),
                'date' => $feedback->getCreatedAt()->format('Y-m-d')
            ];
        }, $feedbacks);


        return $this->render('home/index.html.twig', [
            'feedbacks' => $formattedFeedbacks
        ]);
    }
}
