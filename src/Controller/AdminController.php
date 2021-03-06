<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $partiRepo;

    function __construct(ParticipantRepository $partiRepo)
    {
        $this->partiRepo = $partiRepo;
    }


    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $listeParticipants = $this->partiRepo->findAll();

            $nom = $paginator->paginate(
                $listeParticipants, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                10 // Nombre de résultats par page
            );

            return $this->render('admin/index.html.twig', [
                'nom' => $nom,
            ]);
        }
        return $this->redirectToRoute('app_logout');

    }

    /**
     * @Route("/admin/{id}", name="app_admin_desact")
     */
    public function desactiver($id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->partiRepo->find($id);
        $user->setActif(false);

        $entityManager->flush();

        return $this->redirectToRoute('app_admin',
        );
    }

    /**
     * @Route("/admina/{id}", name="app_admin_activ")
     */
    public function activer($id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->partiRepo->find($id);
        $user->setActif(true);

        $entityManager->flush();

        return $this->redirectToRoute('app_admin',
        );
    }

    /**
     * @Route("/adminsup/{id}", name="app_admin_sup")
     */
    public function bannir($id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->partiRepo->find($id);
        try {
            $this->partiRepo->remove($user);
        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
        }

        return $this->redirectToRoute('app_admin',
        );
    }


    /**
     * @Route("/admin/ajoutCsv", name="app_admin_ajoutCsv")
     */
    public function indexAjoutCsv(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {


            return $this->render('admin/index.html.twig', [

            ]);
        }
        return $this->redirectToRoute('app_logout');

    }



}
