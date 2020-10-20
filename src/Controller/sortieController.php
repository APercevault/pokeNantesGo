<?php 
// src/Controller/sortieController.php
namespace App\Controller;

use App\Entity\Sortie;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class sortieController extends AbstractController
{
    /**
     * @Route("/lesSorties", name="lesSorties")
     */
    public function lesSorties(Request $request, PaginatorInterface $paginator)
    {
        $repository = $this->getDoctrine()->getRepository(Sortie::class);
        $sorties = $repository->findAll();
        
        $sorties = $paginator->paginate(
            $sorties, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
        
        return $this->render(
        'sorties/index.html.twig',
        array('sorties' => $sorties
    ));
    }
}

