<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SkillController extends Controller
{
    /**
     * @Route("/skill", name="skill.index")
     */
    public function indexAction()
    {
        
        return $this->render('admin/skill/index.html.twig', [

        ]);
    }
}
