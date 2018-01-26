<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TrainningController extends Controller
{
    /**
     * @Route("/trainning", name="trainning.index")
     */
    public function indexAction()
    {
        return $this->render('admin/trainnnig/index.html.twig', [

        ]);
    }
}
