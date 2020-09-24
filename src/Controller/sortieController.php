<?php 
// src/Controller/sortieController.php
namespace App\Controller;

use App\Entity\Sortie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class sortieController extends AbstractController
{
    /**
     * @Route("/lesSorties", name="lesSorties")
     */
    public function lesSorties()
    {

        $repository = $this->getDoctrine()->getRepository(Sortie::class);
        $sorties = $repository->findAll();

        return $this->render(
        'sorties/index.html.twig',
        array('sorties' => $sorties));
    }
}

