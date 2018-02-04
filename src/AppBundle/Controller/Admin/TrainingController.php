<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Training;
use AppBundle\Form\TrainingType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/admin")
 */
class TrainingController extends Controller
{
    /**
     * @Route("/training/delete/{id}", name="training.delete")
     */
    public function deleteAction(ManagerRegistry $doctrine, TranslatorInterface $translator, int $id):Response
    {
        // doctrine
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Training::class);

        // séléction de l'entité
        $entity = $rc->find($id);

        //suppression
        $em->remove($entity);

        $em->flush();

        $this->addflash('notice', ucfirst($translator->trans('admin.flash_message.training.delete_training')) );
        //exit;
        // redirection
        return $this->redirectToRoute('training.index');
    }


    /**
     * @Route("/training/form", name="training.form", defaults={"id" = null})
     * @Route("/training/update/{id}", name="training.update")
     */
    public function formAction(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, int $id = null):Response
    {
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Training::class);

        $training = $id ? $rc->find($id) : new Training();

        $type = TrainingType::class;

        $form = $this->createForm($type, $training);

        $form->handleRequest($request);

        // valide
        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);

            $em->flush();
            // message flash
            $this->addflash('notice', $id ? ucfirst($translator->trans('admin.flash_message.training.edit_training')) : ucfirst($translator->trans('admin.flash_message.training.new_training')));
            //exit;
            // redirection
            return $this->redirectToRoute('training.index');
        }
        return $this->render('admin/training/form.html.twig', [
            'form' => $form->createView()
        ]);
    }





    /**
     * @Route("/training", name="training.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc = $doctrine->getRepository(Training::class);

        $training= $rc->findAll();

        return $this->render('admin/training/index.html.twig', [
            'trainings' => $training
        ]);
    }
}
