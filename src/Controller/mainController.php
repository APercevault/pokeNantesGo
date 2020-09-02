<?php 
// src/Controller/mainController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class mainController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home()
    {




        return $this->render('home/index.html.twig');
        }
    }

