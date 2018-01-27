<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class TrainingController extends Controller
{
    /**
     * @Route("/training", name="training.index")
     */
    public function indexAction()
    {
        return $this->render('admin/training/index.html.twig');
    }
}
