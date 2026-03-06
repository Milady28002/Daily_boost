<?php

namespace App\DataFixtures;

use App\Entity\Quote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuoteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $quotes = [
            ['Morning Energy', 'Commence ta journée avec puissance', 'New Daily Boost'],
            ['Focus Power', 'Clarté mentale maximale', 'New Daily Boost'],
            ['Zen Reset', 'Recharge mentale et calme', 'New Daily Boost'],
        ];

        foreach ($quotes as [$title, $content, $author]) {
            $quote = new Quote();
            $quote->setTitle($title);
            $quote->setContent($content);
            $quote->setAuthor($author);
            $quote->setIsFavorite(false);
            $quote->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($quote);
        }

        $manager->flush();
    }
}