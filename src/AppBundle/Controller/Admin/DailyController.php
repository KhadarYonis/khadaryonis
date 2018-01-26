<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DailyController extends Controller
{
    /**
     * @Route("/daily", name="daily.index")
     */
    public function indexAction()
    {
        return $this->render('admin/daily/index.html.twig', [

        ]);
    }
}
