<?php

namespace App\Controller;

use App\Entity\ShowRoom;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ShowRoomType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\ShowRoomRepository;



class ShowRoomController extends AbstractController
{
    #[Route('/show/room', name: 'app_show_room')]
    public function index(): Response
    {
        return $this->render('show_room/index.html.twig', [
            'controller_name' => 'ShowRoomController',
        ]);
    }

#[Route('/addShowRoom ', name: 'addShowRoom ')]
    public function addShowroom (ManagerRegistry $manager , Request $req):Response
    {
        $em = $manager->getManager();
        $ShowRoom = new ShowRoom ();
        $form = $this->createForm(ShowroomType::class,$ShowRoom);
        $form->add('Ajouter',type:submitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid())
        {
            $em->persist($ShowRoom);
            $em->flush();
        }
        
        return $this->render ('/showroom/addShowRoom.html.twig',[
            'Showroom'=>$form
        ]);
    }
    #[Route('/showShowRoom', name: 'showShowRoom')]
    public function showShowRoom (ShowRoomRepository $showRoomRepository)
    {
        $showroom =$showRoomRepository->findAll();

        return $this->render ('showroom/showShowroom.html.twig', [
          'showroom'=>$showroom
        ]);
    }
    #[Route('/editShowRoom/{id}', name: 'editShowRoom')]
    public function editShowRoom($id, ManagerRegistry $managerRegistry, ShowRoomRepository $ShowRoomRepository, Request $request): Response
    {
        // var_dump($id) . die();
    
        $em = $managerRegistry->getManager();
        $idData = $ShowRoomRepository->find($id);
        // var_dump($idData) . die();
        $form = $this->createForm(ShowRoomType::class, $idData);
        $form->add('Edit',type: SubmitType::class);//bouton
        $form->handleRequest($request);
    
        if ($form->isSubmitted() and $form->isValid()) 
        {
            $em->persist($idData);
            $em->flush();
    
            return $this->redirectToRoute('showShowRoom');
        }
        return $this->render ('showroom/editShowRoom.html.twig', ['form' => $form ]);

}
#[Route('/deleteShowRoom/{id}', name: 'deleteShowRoom')]
public function deleteShowRoom($id, ManagerRegistry $managerRegistry, ShowRoomRepository $repository): Response
{
    $emm = $managerRegistry->getManager();
    $idremove = $repository->find($id);
    $emm->remove($idremove);
    $emm->flush();


    return $this->redirectToRoute('showShowRoom');
}


}
