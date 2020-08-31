<?php
// src/Controller/profilController.php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class profilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function profil(Request $request)
    {
        $profil = new User();

        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $profil);

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add('Email',      TextType::class)
            ->add('username',     TextType::class)
            ->add('Password',   PasswordType::class)
            ->add('Password',    PasswordType::class)
            ->add('image',    FileType::class)
            ->add('Valider',      SubmitType::class);
        // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        return $this->render('profil/index.html.twig', array(
            'form' => $form->createView(),
          ));
    }
}
