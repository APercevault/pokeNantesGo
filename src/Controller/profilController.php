<?php
// src/Controller/profilController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class profilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function profil(Request $request)
    {

//  // On vérifie que les valeurs entrées sont correctes
//  if ($form->isValid()) {
//     $image = $profil->getImage();
//     $imageName = md5(uniqid()).'.'.$image->guessExtension();
//     $profil->setImage($imageName);
//     try {
//         $image->move(
//             $this->getParameter("images_directory"),
//             $imageName
//         );
//     } catch (FileException $e) {
//         //throw $e;
//     }

        return $this->render('profil/index.html.twig'

        );
    }
}
