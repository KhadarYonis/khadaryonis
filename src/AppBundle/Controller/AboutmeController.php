<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Daily;
use AppBundle\Entity\Service;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AboutmeController extends Controller
{
    /**
     * @Route("/about_me", name="aboutme.public.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc_service = $doctrine->getRepository(Service::class);
        $rc_daily = $doctrine->getRepository(Daily::class);
        $rc_contact = $doctrine->getRepository(Contact::class);

        $service = $rc_service->findAll();
        $daily = $rc_daily->findAll();
        $contact = $rc_contact->findAll();

        return $this->render('aboutme/index.html.twig', [
            'services' => $service,
            'daily' => $daily,
            'contacts' => $contact
        ]);
    }
}
