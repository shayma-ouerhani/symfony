<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{   public   $authors = array(
    array('id' => 1, 'picture' => '/image/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
    array('id' => 2, 'picture' => '/image/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
    array('id' => 3, 'picture' => '/image/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
    ); 

     #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/showauthor/{name}', name: 'showauthor')]
    public function showAuthor ($name)
    {
        return $this->render('author/show.html.twig',['name' => $name]);
    }

    #[Route('/showlist', name: 'showlist')]
    public function list()
    {  
      
        return $this->render ("author/list.html.twig",['author'=>$this->authors]);

    }
    #[Route('/authorDetails/{id}', name: 'authorDetails')]
    public function authorDetails($id): Response
    {
        //var_dump($id) . die();

        $author = null;
        foreach ($this->authors  as $authorData) {
            if ($authorData['id'] == $id) {
                $author = $authorData;
            }
        }

        return $this->render('author/details.html.twig', [
            'author' => $author
        ]);
    }
    #[Route('/Affiche', name: 'Affiche')]
    public function Affiche (AuthorRepository $repository)
    {
        $author=$repository->findAuthorByemail();
        return $this->render('author/Affiche.html.twig',['author'=>$author]);


    }
  
    #[Route('/addstaticSauthor', name: 'addstaticSauthor')]
    public function addstaticSauthor(ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();
        $author = new Author();

        $author->setUsername("3a56");
        $author->setEmail("3a56@esprit.tn");
        $em->persist($author);
        $em->flush();

        return new Response("add with succcess");
    }

    #[Route('/addauthor', name: 'addauthor')]
    public function addauthor(ManagerRegistry $manager,Request $request):Response
    {   $em = $manager->getManager();
        $author=new Author();
        $form=$this->createForm(AuthorType::class,$author);
        $form->add('Ajouter',type: SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid())
         {
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('Affiche',);
        }
        return $this->render('author/Add.html.twig',['form'=>$form ->createView()]);
          


}

#[Route('/editauthor/{id}', name: 'editauthor')]
public function editauthor($id, ManagerRegistry $managerRegistry, AuthorRepository $authorRepository, Request $request): Response
{
    // var_dump($id) . die();

    $em = $managerRegistry->getManager();
    $idData = $authorRepository->find($id);
    // var_dump($idData) . die();
    $form = $this->createForm(AuthorType::class, $idData);
    $form->add('Edit',type: SubmitType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() and $form->isValid()) {
        $em->persist($idData);
        $em->flush();

        return $this->redirectToRoute('Affiche');
    }

    return $this->render ('author/edit.html.twig', ['form' => $form ]);
}

#[Route('/deleteauthor/{id}', name: 'deleteauthor')]
public function deleteauthor($id, ManagerRegistry $managerRegistry, AuthorRepository $repository): Response
{
    $emm = $managerRegistry->getManager();
    $idremove = $repository->find($id);
    $emm->remove($idremove);
    $emm->flush();


    return $this->redirectToRoute('Affiche');
}




}
