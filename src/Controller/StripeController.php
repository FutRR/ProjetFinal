<?php

namespace App\Controller;

use Stripe\Charge;
use Stripe\Stripe;
use App\Entity\Niveau;
use Flasher\Symfony\Http\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    #[Route('/stripe', name: 'app_stripe')]
    public function index(): Response
    {
        return $this->render('stripe/index.html.twig', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
        ]);
    }

    #[Route("/stripe/create-charge/{id}", name: "app_stripe_charge", methods: ['POST'])]
    public function createCharge(Niveau $niveau, Request $request, EntityManagerInterface $entityManager): Response
    {
        Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        Charge::create([
            "amount" => $niveau->getPrix(),
            "currency" => 'eur',
            "source" => $request->request->get('stripeToken'),
            "description" => "Maesterclass payment test"
        ]);
        $this->addFlash("success", "Paiement réussi");
        return $this->redirectToRoute("app_stripe", [], Response::HTTP_SEE_OTHER);
    }
}
