<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class LivreController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function liste(EntityManagerInterface $entityManager): Response
    {
        $livres = $entityManager->getRepository(Livre::class)->findAll();

        return $this->render('livre/liste.html.twig', ['livres' => $livres]);
    }

    #[Route('/livre/{id}', name: 'livre')]
    public function detail(EntityManagerInterface $entityManager, int $id): Response
    {
        $livre = $entityManager->getRepository(Livre::class)->find($id);

        if (!$livre) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('livre/detail.html.twig', ['livre' => $livre]);
    }

    #[Route('/livre_ajouter', name: 'livre_ajouter')]
    public function ajouter(EntityManagerInterface $entityManager, Request $request): Response
    {
        $livre = new Livre();
        $livre->setDateAjout(new \DateTime());
        $form = $this->createForm(LivreType::class, $livre, [
            'modif' => false, // Paramètre pour la création
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->render('livre/form.html.twig', [
            'form' => $form->createView(),
            'titre' => 'Ajouter',
        ]);
    }

    #[Route('/livre_modif/{id}', name: 'livre_modif')]
    public function modifier(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $livre = $entityManager->getRepository(Livre::class)->find($id);
        $form = $this->createForm(LivreType::class, $livre, [
            'modif' => true, // Paramètre pour la création
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->render('livre/form.html.twig', [
            'form' => $form->createView(),
            'titre' => 'Modifier',
        ]);
    }

    #[Route('/livre_supprimer/{id}', name: 'livre_supprimer')]
    public function supprimer(EntityManagerInterface $entityManager, int $id): Response
    {
        $livre = $entityManager->getRepository(Livre::class)->find($id);
        $entityManager->remove($livre);
        $entityManager->flush();

        $this->addFlash('success', 'Le livre a été supprimé avec succès.');

        return $this->redirectToRoute('accueil');
    }

    #[Route('/livre_vote/{id}', name: 'livre_vote')]
    public function incrementerVotes(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        $livre = $entityManager->getRepository(Livre::class)->find($id);
        $livre->incrementerVotes();
        $entityManager->flush();

        return $this->json(['votes' => $livre->getVotes()]);
    }
}
