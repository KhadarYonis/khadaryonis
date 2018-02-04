<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact.public.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc = $doctrine->getRepository(Contact::class);

        $contact = $rc->findAll();

        return $this->render('contact/index.html.twig', [
            'contacts' => $contact
        ]);
    }
}
