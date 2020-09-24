<?php
// src/Controller/registerController.php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class registerController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();

        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add('Email',      TextType::class)
            ->add('username',     TextType::class)
            ->add('Password',   PasswordType::class)
            ->add('Valider',      SubmitType::class);

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();



        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {



            $Email = $form->get("Email")->getData();
            $username = $form->get("username")->getData();
            $Password = $form->get("Password")->getData();

            $user->setPassword($username);
            $user->setEmail($Email);
            $user->setStatus(false);
            $user->setRole(array('ROLE_USER'));

            // Encode le mot de passe
            $Password = $passwordEncoder->encodePassword($user, $Password);
            $user->setPassword($Password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return
            $this->redirectToRoute('home');
        }
        return $this->render('register/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
