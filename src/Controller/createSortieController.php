<?php
// src/Controller/createSortieController.php
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

class createSortieController extends AbstractController
{
    /**
     * @Route("/createSortie", name="createSortie")
     */
    public function createSortie(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $sortie = new Sortie();
        $user = $this->getUser();
        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $sortie);

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add('title',     TextType::class)
            ->add('content',   TextareaType::class)
            ->add('location',   TextType::class)
            ->add('numberUser',   NumberType::class)
            ->add('date',   DateTimeType::class)
            ->add('Valider',      SubmitType::class);

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $title = $form->get("title")->getData();
            $content = $form->get("content")->getData();
            $location = $form->get("location")->getData();
            $numberUser = $form->get("numberUser")->getData();
            $date = $form->get("date")->getData();

            $sortie->setTitle($title);
            $sortie->setContent($content);
            $sortie->setLocation($location);
            $sortie->setNumberUser($numberUser);
            $sortie->setDate($date);
            $sortie->addUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($sortie);
            $em->flush();
            return
                $this->redirectToRoute('mesSorties');
        }

        return
            $this->render(
                'createSortie/index.html.twig',
                array(
                    'form' => $form->createView(),
                ),
            );
    }
}
