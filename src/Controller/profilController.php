<?php
// src/Controller/profilController.php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class profilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function profil(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $profil = $this->getUser();

        $form = $this->createFormBuilder($profil)
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('password', PasswordType::class)
            ->add('image', FileType::class, [
                'label' => 'Image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])
            ->add('valider', SubmitType::class)

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $username = $form->get("username")->getData();
            $Password = $form->get("password")->getData();
            $Password = $passwordEncoder->encodePassword($profil, $Password);
            $Email = $form->get("email")->getData();
            $Image = $form->get("image")->getData();

            // this condition is needed because the 'Image' field is not required
            // so the Image file must be processed only when a file is uploaded
            if ($Image) {
                $originalFilename = pathinfo($Image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $slugger = new AsciiSlugger();
                $safeFilename = $slugger->slug($originalFilename);

                $newFilename = $safeFilename . '-' . uniqid() . '.' . $Image->guessExtension();
                // Move the file to the directory where Images are stored
                try {
                    $path = $this->getParameter('images_directory');
                    $fs = new Filesystem();
                    $fs->remove($path);
                    
                    $Image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'ImageFilename' property to store the PDF file name
                // instead of its contents

                $profil->setImage($Image);
            }
            $profil->setUsername($username);
            $profil->setPassword($Password);
            $profil->setEmail($Email);


            $entityManager  = $this->getDoctrine()->getManager();
            $entityManager->persist($profil);
            $entityManager->flush();
        }




        return $this->render('profil/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
