<?php 
// src/Controller/sortieController.php
namespace App\Controller;

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
        return $this->render('sorties/index.html.twig');
        }
    }

