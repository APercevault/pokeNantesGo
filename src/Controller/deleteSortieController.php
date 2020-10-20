<?php
// src/Controller/deleteSortieController.php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Sortie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class deleteSortieController extends AbstractController
{
    /**
     * @Route("/deleteSortie/{id}", name="deleteSortie")
     */
    public function deleteSortie(Sortie $sortie, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($sortie);
        $em->flush();

        return
            $this->redirectToRoute('mesSorties');

    }
}
