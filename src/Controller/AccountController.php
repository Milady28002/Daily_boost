<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[IsGranted('ROLE_USER')]
class AccountController extends AbstractController
{
    #[Route('/mon-compte/supprimer', name: 'account_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        if (!$this->isCsrfTokenValid(
            'delete_account_' . $user->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        // Déconnecte l'utilisateur avant de supprimer son entité
        $tokenStorage->setToken(null);

        // Supprime le compte
        $entityManager->remove($user);
        $entityManager->flush();

        // Supprime la session
        $request->getSession()->invalidate();

        return $this->redirectToRoute('home');
    }
}