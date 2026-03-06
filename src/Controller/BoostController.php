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

class BoostController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(QuoteRepository $quoteRepository): Response
    {
        $quotes = $quoteRepository->findAll();
        $count = count($quotes);
        $favoritesCount = $quoteRepository->count(['isFavorite' => true]);
        $lastQuote = $quoteRepository->findOneBy([], ['createdAt' => 'DESC']);

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

    #[Route('/quote/new', name: 'quote_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $quote = new Quote();

        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quote->setCreatedAt(new \DateTimeImmutable());
            $quote->setIsFavorite(false);

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
    public function list(QuoteRepository $quoteRepository): Response
    {
        $quotes = $quoteRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('quote/list.html.twig', [
            'quotes' => $quotes,
        ]);
    }

    #[Route('/quote/{id}/favorite', name: 'quote_toggle_favorite')]
    public function toggleFavorite(Quote $quote, EntityManagerInterface $em): Response
    {
        $quote->setIsFavorite(!$quote->isFavorite());

        $em->flush();

        return $this->redirectToRoute('quote_list');
    }

    #[Route('/favorites', name: 'quote_favorites')]
    public function favorites(QuoteRepository $quoteRepository): Response
    {
        $quotes = $quoteRepository->findFavorites();

        return $this->render('quote/favorites.html.twig', [
            'quotes' => $quotes,
        ]);
    }

    #[Route('/random', name: 'quote_random')]
    public function random(QuoteRepository $quoteRepository): Response
    {
        $quotes = $quoteRepository->findAll();
        $count = count($quotes);
        $favoritesCount = $quoteRepository->count(['isFavorite' => true]);
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
    #[Route('/quote*{id}/edit', name: 'quote_edit')]
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
}