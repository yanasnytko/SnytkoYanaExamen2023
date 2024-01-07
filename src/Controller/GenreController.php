<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    #[Route('/genres', name: 'genres')]
    public function liste(EntityManagerInterface $entityManager): Response
    {
        $genres = $entityManager->getRepository(Genre::class)->findAll();

        return $this->render('genre/liste.html.twig', ['genres' => $genres]);
    }

    #[Route('/genre_ajouter', name: 'genre_ajouter')]
    public function ajouter(EntityManagerInterface $entityManager, Request $request): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($genre);
            $entityManager->flush();

            return $this->redirectToRoute('genres');
        }

        return $this->render('genre/form.html.twig', [
            'form' => $form->createView(),
            'titre' => 'Ajouter',
        ]);
    }

    #[Route('/genre_modif/{id}', name: 'genre_modif')]
    public function modifier(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $genre = $entityManager->getRepository(Genre::class)->find($id);
        $form = $this->createForm(GenreType::class, $genre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($genre);
            $entityManager->flush();

            return $this->redirectToRoute('genres');
        }

        return $this->render('genre/form.html.twig', [
            'form' => $form->createView(),
            'titre' => 'Modifier',
        ]);
    }
}
