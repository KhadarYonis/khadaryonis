<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact.index")
     */
    public function indexAction()
    {
        return $this->render('admin/contact/index.html.twig', [

        ]);
    }
}
