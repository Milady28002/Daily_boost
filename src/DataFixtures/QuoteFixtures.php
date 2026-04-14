<?php

namespace App\DataFixtures;

use App\Entity\Quote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuoteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $quotesData = [

            [
                'title' => 'Audace',
                'content' => 'Apprends les règles comme un professionnel afin de pouvoir les briser comme un artiste.',
                'author' => 'Pablo Picasso',
                'favorite' => true
            ],
            [
                'title' => 'Éveil',
                'content' => 'Le véritable voyage ne consiste pas à chercher de nouveaux paysages, mais à avoir de nouveaux yeux.',
                'author' => 'Marcel Proust',
                'favorite' => true
            ],
            [
                'title' => 'Discipline',
                'content' => 'On ne se motive pas, on se discipline.',
                'author' => 'Anonyme',
                'favorite' => false
            ],
            [
                'title' => 'Action',
                'content' => 'Un petit pas aujourd’hui vaut mieux qu’un grand demain.',
                'author' => 'Anonyme',
                'favorite' => false
            ],
            [
                'title' => 'Courage',
                'content' => 'Le courage n’est pas l’absence de peur, mais la capacité de la vaincre.',
                'author' => 'Nelson Mandela',
                'favorite' => false
            ],
            [
                'title' => 'Focus',
                'content' => 'Là où va ton attention, va ton énergie.',
                'author' => 'Anonyme',
                'favorite' => false
            ],
            [
                'title' => 'Persévérance',
                'content' => 'Le succès est la somme de petits efforts répétés jour après jour.',
                'author' => 'Robert Collier',
                'favorite' => false
            ],
            [
                'title' => 'Simplicité',
                'content' => 'Fais simple. Fais propre. Et recommence demain.',
                'author' => 'New Daily Boost',
                'favorite' => false
            ],
        ];

        foreach ($quotesData as $data) {
            $quote = new Quote();
            $quote->setTitle($data['title']);
            $quote->setContent($data['content']);
            $quote->setAuthor($data['author']);
            $quote->setIsFavorite($data['favorite']);
            $quote->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($quote);
        }

        $manager->flush();
    }
}