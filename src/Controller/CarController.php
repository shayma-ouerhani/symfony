<?php

namespace App\Controller;
use App\Form\CarType;
use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ShowCarRepository;


class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(): Response
    {
        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
        ]);
    }
    #[Route('/addCar', name: 'addCar')]
    public function addCar (ManagerRegistry $manager,Request $request):Response
    {   $em = $manager->getManager();
        $Car=new Car();
        $form=$this->createForm(CarType::class,$Car);
       // $form->add('Ajouter',type: SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid())
         {
            $em->persist($Car);
            $em->flush();
        }
        return $this->render ('/car/addCar.html.twig',[
            'car'=>$form
        ]);
          
}

}

