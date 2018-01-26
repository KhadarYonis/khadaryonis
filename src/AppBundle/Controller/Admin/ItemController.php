<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ItemController extends Controller
{
    /**
     * @Route("/item", name="item.index")
     */
    public function indexAction()
    {
        return $this->render('admin/item/index.html.twig', [

        ]);
    }
}
