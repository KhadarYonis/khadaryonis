<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Entity\Skill;
use AppBundle\Entity\Training;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ResumeController extends Controller
{
    /**
     * @Route("/resume", name="resume.public.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc_trainning = $doctrine->getRepository(Training::class);
        $rc_project = $doctrine->getRepository(Project::class);
        $rc_skill = $doctrine->getRepository(Skill::class);

        $training = $rc_trainning->findAll();
        $project = $rc_project->findAll();
        $skill = $rc_skill->findAll();

        return $this->render('resume/index.html.twig', [
            'trainings' => $training,
            'projects' => $project,
            'skills' => $skill
        ]);
    }
}
