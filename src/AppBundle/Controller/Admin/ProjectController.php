<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class ProjectController extends Controller
{
    /**
     * @Route("/project", name="project.index")
     */
    public function indexAction()
    {
        return $this->render('admin/project/index.html.twig');
    }
}
