<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Site;
use App\Form\ModifParticipantType;
use App\Repository\ParticipantRepository;

use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifierProfilControlerController extends AbstractController
{

    private $partiRepo;
    private $siteRepo;

    function __construct(ParticipantRepository $partiRepo, SiteRepository $siteRepo)
    {
        $this->partiRepo = $partiRepo;
        $this->siteRepo = $siteRepo;

    }

    /**
     * @Route("/profil", name="app_profil")
     */
    public function index(ParticipantRepository $participantRepository,EntityManagerInterface $em,Request $request): Response
    {
        $user = new Participant();
       // $user->setNom($user);
        $user = $this->getUser();
        $formModif = $this->createForm(ModifParticipantType::class, $user);
        $formModif->handleRequest($request);

        if($formModif->isSubmitted() && $formModif->isValid()) {
            $em->flush();

            return $this->redirectToRoute("app_profil");
        }


        return $this->render("mon_profil/index.html.twig",
            ['formModif' => $formModif->createView()]);
    }
}
