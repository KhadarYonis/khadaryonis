<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/admin")
 */
class ProjectController extends Controller
{
    /**
     * @Route("/project/delete/{id}", name="project.delete")
     */
    public function deleteAction(ManagerRegistry $doctrine, TranslatorInterface $translator, int $id):Response
    {
        // doctrine
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Project::class);

        // séléction de l'entité
        $entity = $rc->find($id);

        //suppression
        $em->remove($entity);

        $em->flush();

        $this->addflash('notice', ucfirst($translator->trans('admin.flash_message.project.delete_training')) );
        //exit;
        // redirection
        return $this->redirectToRoute('project.index');
    }


    /**
     * @Route("/project/form", name="project.form", defaults={"id" = null})
     * @Route("/project/update/{id}", name="project.update")
     */
    public function formAction(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, int $id = null):Response
    {
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Project::class);

        $training = $id ? $rc->find($id) : new Project();

        $type = ProjectType::class;

        $form = $this->createForm($type, $training);

        $form->handleRequest($request);

        // valide
        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);

            $em->flush();
            // message flash
            $this->addflash('notice', $id ? ucfirst($translator->trans('admin.flash_message.project.edit_project')) : ucfirst($translator->trans('admin.flash_message.project.new_project')));
            //exit;
            // redirection
            return $this->redirectToRoute('project.index');
        }
        return $this->render('admin/project/form.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/project", name="project.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc = $doctrine->getRepository(Project::class);

        $project= $rc->findAll();

        return $this->render('admin/project/index.html.twig', [
            'projects' => $project
        ]);
    }
}
