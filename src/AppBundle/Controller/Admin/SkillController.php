<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Skill;
use AppBundle\Form\SkillType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/admin")
 */
class SkillController extends Controller
{
    /**
     * @Route("skill/delete/{id}", name="skill.delete")
     */
    public function deleteAction(ManagerRegistry $doctrine, TranslatorInterface $translator, int $id):Response
    {
        // doctrine
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Skill::class);
        // séléction de l'entité
        $entity = $rc->find($id);
        //suppression
        $em->remove($entity);
        $em->flush();
        $this->addflash('notice', $translator->trans('flash_message.skill.delete_skill') );
        //exit;
        // redirection
        return $this->redirectToRoute('skill.index');
    }



    /**
     * @Route("/skill/form", name="skill.form", defaults={"id" = null})
     * @Route("/skill/update/{id}", name="skill.update")
     */
    public function formAction(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, int $id = null):Response
    {
        $em = $doctrine->getManager();

        $rc = $doctrine->getRepository(Skill::class);

        $category = $id ? $rc->find($id) : new Skill();

        $type = SkillType::class;

        $form = $this->createForm($type, $category);

        $form->handleRequest($request);
        // valide
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            //dump($data); exit;
            $em->persist($data);
            $em->flush();
            // message flash
            $this->addflash('notice', $id ? $translator->trans('flash_message.skill.edit_skill') : $translator->trans('flash_message.skill.new_skill'));
            //exit;
            // redirection
            return $this->redirectToRoute('skill.index');
        }
        return $this->render('admin/skill/form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/skill", name="skill.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc = $doctrine->getRepository(Skill::class);
        $skill = $rc->findAll();

        return $this->render('admin/skill/index.html.twig', [
            'skills' => $skill
        ]);
    }
}
