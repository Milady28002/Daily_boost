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
                'author' => 'Pablo Picasso'
            ],
            [
                'title' => 'Éveil',
                'content' => 'Le véritable voyage ne consiste pas à chercher de nouveaux paysages, mais à avoir de nouveaux yeux.',
                'author' => 'Marcel Proust'
            ],
            [
                'title' => 'Discipline',
                'content' => 'On ne se motive pas, on se discipline.',
                'author' => 'Anonyme'
            ],
            [
                'title' => 'Action',
                'content' => 'Un petit pas aujourd’hui vaut mieux qu’un grand demain.',
                'author' => 'Anonyme'
            ],
            [
                'title' => 'Courage',
                'content' => 'Le courage n’est pas l’absence de peur, mais la capacité de la vaincre.',
                'author' => 'Nelson Mandela'
            ],
            [
                'title' => 'Focus',
                'content' => 'Là où va ton attention, va ton énergie.',
                'author' => 'Anonyme'
            ],
            [
                'title' => 'Persévérance',
                'content' => 'Le succès est la somme de petits efforts répétés jour après jour.',
                'author' => 'Robert Collier'
            ],
            [
                'title' => 'Simplicité',
                'content' => 'Fais simple. Fais propre. Et recommence demain.',
                'author' => 'New Daily Boost'
            ],
        ];

        foreach ($quotesData as $data) {
            $quote = new Quote();
            $quote->setTitle($data['title']);
            $quote->setContent($data['content']);
            $quote->setAuthor($data['author']);
            $quote->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($quote);
        }

        $manager->flush();
    }
}