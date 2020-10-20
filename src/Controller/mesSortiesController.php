<?php
// src/Controller/mesSortiesController.php
namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class mesSortiesController extends AbstractController
{
    /**
     * @Route("/mesSorties", name="mesSorties")
     */
    public function mesSortie(UserRepository $userRepository)
    {
        $userId = $this->getUser()->getId();
        $userUsername = $this->getUser()->getUsername();
        $userSorties = $userRepository->findOneBy(['id'=>$userId]);

        
        return $this->render(
            'mesSorties/index.html.twig',
            array('userSorties' => $userSorties,
            'userUsername' => $userUsername)
        );
    }
}
