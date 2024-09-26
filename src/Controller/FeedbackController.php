<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Entity\Participated;
use App\Form\FeedbackEntryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FeedbackController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
    #[Route('/feedback', name: 'feedback')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $feedbacks = new \ArrayObject();

        $form = $this->createForm(FeedbackEntryType::class, ['feedbacks' => $feedbacks]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $submittedFeedbacks = $form->get('feedbacks')->getData();

            foreach ($submittedFeedbacks as $feedback) {
                $feedback->setCreatedAt(new \DateTimeImmutable());
                $entityManager->persist($feedback);
            }

            $entityManager->flush();

            $participated = new Participated();
            $participated->setUserID($this->getUser());
            $participated->setDate(new \DateTimeImmutable());

            $entityManager->persist($participated);
            $entityManager->flush();

            $this->addFlash('success', 'Vos feedbacks ont bien été pris en compte.');
            return $this->redirectToRoute('home');
        }
        return $this->render('feedback/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
