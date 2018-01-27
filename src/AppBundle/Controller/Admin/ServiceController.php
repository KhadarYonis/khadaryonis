<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class ServiceController extends Controller
{
    /**
     * @Route("/service", name="service.index")
     */
    public function indexAction()
    {
        return $this->render('admin/service/index.html.twig');
    }
}
