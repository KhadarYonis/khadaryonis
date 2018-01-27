<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/category", name="category.index")
     */
    public function indexAction()
    {
        return $this->render('admin/category/index.html.twig');
    }
}
