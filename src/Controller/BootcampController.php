<?php

namespace App\Controller;

use App\Entity\Bootcamp;
use App\Form\BootcampType;
use App\Repository\BootcampRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bootcamp')]
class BootcampController extends AbstractController
{
    #[Route('/', name: 'app_bootcamp_index', methods: ['GET'])]
    public function index(BootcampRepository $bootcampRepository): Response
    {
        return $this->render('bootcamp/index.html.twig', [
            'bootcamps' => $bootcampRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bootcamp_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bootcamp = new Bootcamp();
        $form = $this->createForm(BootcampType::class, $bootcamp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bootcamp);
            $entityManager->flush();

            return $this->redirectToRoute('app_bootcamp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bootcamp/new.html.twig', [
            'bootcamp' => $bootcamp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bootcamp_show', methods: ['GET'])]
    public function show(Bootcamp $bootcamp): Response
    {
        return $this->render('bootcamp/show.html.twig', [
            'bootcamp' => $bootcamp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bootcamp_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bootcamp $bootcamp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BootcampType::class, $bootcamp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bootcamp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bootcamp/edit.html.twig', [
            'bootcamp' => $bootcamp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bootcamp_delete', methods: ['POST'])]
    public function delete(Request $request, Bootcamp $bootcamp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bootcamp->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bootcamp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bootcamp_index', [], Response::HTTP_SEE_OTHER);
    }
}
