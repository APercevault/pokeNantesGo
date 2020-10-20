<?php
// src/Controller/addUserSortieController.php
namespace App\Controller;

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

class addUserSortieController extends AbstractController
{
    /**
     * @Route("/addUserSortie/{id}", name="addUserSortie")
     */
    public function addUserSortie(Sortie $sortie, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $addUser = $sortie->addUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($addUser);
        $em->flush();

        return
        $this->redirectToRoute('lesSorties');
    }
    
        /**
     * @Route("/deleteUserSortie/{id}", name="deleteUserSortie")
     */
    public function deleteUserSortie(Sortie $sortie, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $removeUser = $sortie->removeUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($removeUser);
        $em->flush();

        return
        $this->redirectToRoute('lesSorties');
    }
}
