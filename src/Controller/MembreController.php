<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

class MembreController extends AbstractController
{

    #[Route('/membres', name: 'app_membres')]
    public function membres(
        Request $request,
        MembreRepository $membreRepository,
        PaginatorInterface $paginator
    ): Response {
        $recherche = $request->query->get('recherche');

        if ($recherche) {
            $membres = $membreRepository->rechercher($recherche);
        } else {
            $membres = $membreRepository->findAll();
        }

        $pagination = $paginator->paginate(
            $membres,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('membre/index.html.twig', [
            'membres' => $pagination,
            'recherche' => $recherche,
        ]);
    }

    #[Route('/membres/nouveau', name: 'app_membre_nouveau')]
    public function nouveau(Request $request, EntityManagerInterface $entityManager): Response
    {
        $membre = new Membre();

        $form = $this->createForm(MembreType::class, $membre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($membre);
            $entityManager->flush();

            $this->addFlash('success', 'Membre ajouté avec succès !');

            return $this->redirectToRoute('app_membres');
        }

        return $this->render('membre/nouveau.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/membres/{id}/modifier', name: 'app_membre_modifier')]
    public function modifier(
        Membre $membre,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(MembreType::class, $membre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Membre modifié avec succès !');

            return $this->redirectToRoute('app_membres');
        }

        return $this->render('membre/modifier.html.twig', [
            'form' => $form,
            'membre' => $membre,
        ]);
    }

    #[Route('/membres/{id}/supprimer', name: 'app_membre_supprimer', methods: ['POST'])]
    public function supprimer(
        Membre $membre,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $membre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($membre);
            $entityManager->flush();

            $this->addFlash('success', 'Membre supprimé avec succès !');
        }

        return $this->redirectToRoute('app_membres');
    }

}
