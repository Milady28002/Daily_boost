<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteType;
use App\Repository\QuoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Favorite;
use App\Repository\FavoriteRepository;

class BoostController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        QuoteRepository $quoteRepository,
        FavoriteRepository $favoriteRepository,
        Request $request
    ): Response
    {
        $quotes = $quoteRepository->findAll();
        $count = count($quotes);

        if ($this->getUser()) {
            $favorites = $favoriteRepository->findBy([
                'owner' => $this->getUser(),
            ]);
        } else {
            $visitorId = $request->getSession()->get('visitor_id');

            $favorites = $visitorId
                ? $favoriteRepository->findBy([
                    'visitorId' => $visitorId,
                ])
                : [];
        }

        $favoritesCount = count($favorites);

        $lastQuote = $quoteRepository->findOneBy([], [
        'createdAt' => 'DESC'
    ]);

    if (!$quotes) {
        return $this->render('home/index.html.twig', [
            'quote' => null,
            'count' => $count,
            'favoritesCount' => $favoritesCount,
            'lastQuote' => $lastQuote,
        ]);
    }

    $dayNumber = (int) date('z');
    $index = $dayNumber % count($quotes);
    $quoteOfTheDay = $quotes[$index];

        return $this->render('home/index.html.twig', [
            'quote' => $quoteOfTheDay,
            'count' => $count,
            'favoritesCount' => $favoritesCount,
            'lastQuote' => $lastQuote,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/quote/new', name: 'quote_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $quote = new Quote();

        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quote->setCreatedAt(new \DateTimeImmutable());
            $quote->setSubmittedBy($this->getUser());

            $em->persist($quote);
            $em->flush();

            $this->addFlash('success', 'Citation ajoutée avec succès ✨');

            return $this->redirectToRoute('home');
        }

        return $this->render('quote/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/quotes', name: 'quote_list')]
    public function list(
        QuoteRepository $quoteRepository,
        FavoriteRepository $favoriteRepository,
        Request $request
    ): Response {
        $quotes = $quoteRepository->findBy([], [
            'createdAt' => 'DESC',
        ]);

        $favoriteQuoteIds = [];

        if ($this->getUser()) {
            $favorites = $favoriteRepository->findBy([
                'owner' => $this->getUser(),
            ]);
        } else {
            $visitorId = $request->getSession()->get('visitor_id');

            $favorites = $visitorId
                ? $favoriteRepository->findBy([
                    'visitorId' => $visitorId,
                ])
                : [];
        }

        foreach ($favorites as $favorite) {
            $favoriteQuoteIds[] = $favorite->getQuote()->getId();
        }

        return $this->render('quote/list.html.twig', [
            'quotes' => $quotes,
            'favoriteQuoteIds' => $favoriteQuoteIds,
        ]);
    }

    #[Route('/quote/{id}/favorite', name: 'quote_toggle_favorite')]
    public function toggleFavorite(
        Quote $quote,
        FavoriteRepository $favoriteRepository,
        EntityManagerInterface $em,
        Request $request
    ): Response {

        // Utilisateur connecté
        if ($this->getUser()) {

            $favorite = $favoriteRepository->findOneByUserAndQuote(
                $this->getUser(),
                $quote
            );

            if ($favorite) {
                $em->remove($favorite);
            } else {
                $favorite = new Favorite();
                $favorite->setQuote($quote);
                $favorite->setOwner($this->getUser());
                $favorite->setCreatedAt(new \DateTimeImmutable());

                $em->persist($favorite);
            }
        } else {

            // Visiteur anonyme
            $session = $request->getSession();

            if (!$session->has('visitor_id')) {
                $session->set('visitor_id', uniqid('visitor_'));
            }

            $visitorId = $session->get('visitor_id');

            $favorite = $favoriteRepository->findOneByVisitorAndQuote(
                $visitorId,
                $quote
            );

            if ($favorite) {
                $em->remove($favorite);
            } else {
                $favorite = new Favorite();
                $favorite->setQuote($quote);
                $favorite->setVisitorId($visitorId);
                $favorite->setCreatedAt(new \DateTimeImmutable());

                $em->persist($favorite);
            }
        }

        $em->flush();

        return $this->redirectToRoute('quote_list');
    }

    #[Route('/random', name: 'quote_random')]
    public function random(QuoteRepository $quoteRepository): Response
    {
        $quotes = $quoteRepository->findAll();
        $count = count($quotes);
        $favoritesCount = 0;
        $lastQuote = $quoteRepository->findOneBy([], ['createdAt' => 'DESC']);

        if (!$quotes) {
            return $this->render('home/index.html.twig', [
                'quote' => null,
                'count' => $count,
                'favoritesCount' => $favoritesCount,
                'lastQuote' => $lastQuote,
            ]);
        }

        $randomQuote = $quotes[array_rand($quotes)];

        return $this->render('home/index.html.twig', [
            'quote' => $randomQuote,
            'count' => $count,
            'favoritesCount' => $favoritesCount,
            'lastQuote' => $lastQuote,
        ]);
    }
   #[Route('/favorites', name: 'favorites')]
    public function favorites(
        FavoriteRepository $favoriteRepository,
        Request $request
    ): Response
    {
        if ($this->getUser()) {
            $favorites = $favoriteRepository->findBy([
                'owner' => $this->getUser(),
            ]);
        } else {
            $visitorId = $request->getSession()->get('visitor_id');

            $favorites = $visitorId
                ? $favoriteRepository->findBy([
                    'visitorId' => $visitorId,
                ])
                : [];
        }

        $quotes = [];

        foreach ($favorites as $favorite) {
            $quotes[] = $favorite->getQuote();
        }

        return $this->render('quote/favorites.html.twig', [
            'quotes' => $quotes,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/quote/{id}/edit', name: 'quote_edit')]
    public function edit(Quote $quote, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success' , 'Citation modifiée avec succès ✨');

            return $this->redirectToRoute('quote_list');
        }
        return $this->render('quote/edit.html.twig',[
            'form' => $form->createView(),
            'quote' => $quote,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/quote/{id}/delete', name: 'quote_delete', methods: ['POST'])]
    public function delete(Quote $quote, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete_quote_' . $quote->getId(), $request->request->get('_token'))) {
            $em->remove($quote);
            $em->flush();

            $this->addFlash('success', 'Citation supprimée avec succès 🗑️');
        }

            return $this->redirectToRoute('quote_list');
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/stats', name: 'quote_stats')]
    public function stats(QuoteRepository $quoteRepository): Response
    {
        $total = $quoteRepository->count([]);
        $favorites = 0;
        $lastQuote = $quoteRepository->findOneBy([], ['createdAt' => 'DESC']);

        return $this->render('quote/stats.html.twig', [
            'total' => $total,
            'favorites' => $favorites,
            'lastQuote' => $lastQuote,
        ]);
    }
}