<?php
namespace App\Controller;

use App\Entity\Lieu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    /**
     * @Route("/lieu/rechercheAjaxByVille", name="lieu_rechercher_ajax_by_ville")
     */
    public function rechercheAjaxByVille(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        dd($request);
        $lieux = $entityManager->getRepository(Lieu::class)->findBy(['ville' => $request->request->get('ville_id')]);
        $json_data = array();
        $i = 0;
        if (sizeof($lieux) > 0) {
            foreach ($lieux as $lieu) {
                $json_data[$i++] = array('id' => $lieu->getId(), 'nom' => $lieu->getNom());
            }
            return new JsonResponse($json_data);
        } else {
            $json_data[$i++] = array('id' => '', 'nom' => 'Pas de lieu correspondant à votre recherche.');
            return new JsonResponse($json_data);
        }
    }
}