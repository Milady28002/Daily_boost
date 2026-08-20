<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LegalController extends AbstractController
{
    #[Route('/politique-de-confidentialite', name: 'privacy_policy')]
    public function privacy(): Response
    {
        return $this->render('legal/privacy.html.twig');
    }

    #[Route('/mentions-legales', name: 'legal_notice')]
    public function legalNotice(): Response
    {
        return $this->render('legal/legal_notice.html.twig');
    }

    #[Route('/conditions-utilisation', name: 'terms')]
    public function terms(): Response
    {
        return $this->render('legal/terms.html.twig');
    }
}