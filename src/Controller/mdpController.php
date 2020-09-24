<?php
// src/Controller/mdpController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class mdpController extends AbstractController
{
    /**
     * @Route("/mdp", name="mdp")
     */
    public function mdp(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $profil = $this->getUser();
        $form = $this->createFormBuilder($profil)
        ->add('password', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe doivent être identique.',
            'first_options'  => array('label' => 'Mot de passe'),
            'second_options' => array('label' => 'Répeter le mot de passe'),
        ))

        ->add('valider', SubmitType::class)
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $Password = $form->get("password")->getData();
        $Password = $passwordEncoder->encodePassword($profil, $Password);

        $profil->setPassword($Password);

        $entityManager  = $this->getDoctrine()->getManager();
        $entityManager->persist($profil);
        $entityManager->flush();
    }
        return $this->render('mdp/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }}

