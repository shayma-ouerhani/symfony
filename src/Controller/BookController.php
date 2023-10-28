<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Form\RechercheType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/addbook', name: 'addbook')]
    public function addbook(ManagerRegistry $managerRegistry, Request  $request): Response
    {
        $em=$managerRegistry->getManager();
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()){
            $em->persist($book);
            $em->flush();
        }
        return $this-> render('book/addbook.html.twig', [
             'book'=>$form
        ]);
    }
    #[Route('/editbook/{id}', name: 'editbook')]
    public function editbook($id ,ManagerRegistry $managerRegistry,BookRepository $bookRepository, Request  $request): Response
      {
        // var_dump($id) . die();

        $em = $managerRegistry->getManager();
        $idData = $bookRepository->find($id);
        // var_dump($idData) . die();
        $form = $this->createForm(BookType::class, $idData);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($idData);
            $em->flush();

            return $this->redirectToRoute('showbook');
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/deletebook/{id}', name: 'deletebook')]
    public function deletebook($id , ManagerRegistry $managerRegistry , BookRepository $bookRepository ):Respo

    {
        $emm = $managerRegistry->getManager();
        $idremove = $bookRepository->find($id);
        $emm->remove($idremove);
        $emm->flush();


        return $this->redirectToRoute('showbook');
    }

    #[Route('/showbook', name: 'showbook')]
    public function showbook (EntityManagerInterface $em, BookRepository $bookRepository , Request $request):Response
    { 
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);
        $results = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $ref = $form->get('ref')->getData();
            $results= $em->getRepository(Book::class)->findBy(['ref'=> $ref]) ;
            return $this->render('book/showbookAtelier.html.twig', [
                'form' => $form->createView(),
                'results' => $results,


            ]);
        }
        $book =$bookRepository->findAll();

        return $this->render('book/showbook.html.twig',
        ['Book' => $book ,
        'form' => $form->createView()
    ]);
    }

    #[Route('/ShowCondition', name: 'ShowCondition')]
    public function ShowCondition(ManagerRegistry $managerRegistry, BookRepository $repo): Response
   {

         $year = new \DateTime('2015-01-01') ;
        $minBookCount = 20;
        $books = $repo->findBooksPublishedBeforeYearWithAuthorBooksCount($year, $minBookCount);

        return $this->render('book/list.html.twig', [
            'books' => $books,
        ]);
    }
   


}

