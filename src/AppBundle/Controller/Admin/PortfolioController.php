<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class PortfolioController extends Controller
{
    /**
     * @Route("/portfolio", name="portfolio.index")
     */
    public function indexAction()
    {
        return $this->render('admin/portfolio/index.html.twig');
    }
}
