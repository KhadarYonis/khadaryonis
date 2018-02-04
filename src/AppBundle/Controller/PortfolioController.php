<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Carousel;
use AppBundle\Entity\Category;
use AppBundle\Entity\Portfolio;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PortfolioController extends Controller
{
    /**
     * @Route("/portfolio", name="portfolio.public.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc_category = $doctrine->getRepository(Category::class);
        $rc_portfolio = $doctrine->getRepository(Portfolio::class);
        $rc_carousel = $doctrine->getRepository(Carousel::class);

        $category= $rc_category->findAll();
        $portfolio= $rc_portfolio->findAll();
        $carousel= $rc_carousel->findAll();

        return $this->render('portfolio/index.html.twig', [
            'categories' => $category,
            'portfolios' => $portfolio,
            'carousels' => $carousel
        ]);
    }
}
