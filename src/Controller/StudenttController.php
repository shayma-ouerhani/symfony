<?php

namespace App\Controller;

use App\Entity\Studentt;
use App\Form\StudenttType;
use App\Repository\StudenttRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/studentt')]
class StudenttController extends AbstractController
{
    #[Route('/', name: 'app_studentt_index', methods: ['GET'])]
    public function index(StudenttRepository $studenttRepository): Response
    {
        return $this->render('studentt/index.html.twig', [
            'studentts' => $studenttRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_studentt_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $studentt = new Studentt();
        $form = $this->createForm(StudenttType::class, $studentt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($studentt);
            $entityManager->flush();

            return $this->redirectToRoute('app_studentt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('studentt/new.html.twig', [
            'studentt' => $studentt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_studentt_show', methods: ['GET'])]
    public function show(Studentt $studentt): Response
    {
        return $this->render('studentt/show.html.twig', [
            'studentt' => $studentt,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_studentt_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Studentt $studentt, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StudenttType::class, $studentt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_studentt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('studentt/edit.html.twig', [
            'studentt' => $studentt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_studentt_delete', methods: ['POST'])]
    public function delete(Request $request, Studentt $studentt, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentt->getId(), $request->request->get('_token'))) {
            $entityManager->remove($studentt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_studentt_index', [], Response::HTTP_SEE_OTHER);
    }
}
