<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Daily;
use AppBundle\Form\DailyType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/admin")
 */
class DailyController extends Controller
{

    /**
     * @Route("/daily/form", name="daily.form", defaults={"id" = null})
     * @Route("/daily/update/{id}", name="daily.update")
     */
    public function formAction(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, int $id = null):Response
    {
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Daily::class);

        $daily = $id ? $rc->find($id) : new Daily();

        $type = DailyType::class;

        $form = $this->createForm($type, $daily);

        $form->handleRequest($request);

        // valide
        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $file = $form['image']->getData();

            $file->move('img/daily', $file->getClientOriginalName());

            $data->setImage($file->getClientOriginalName());

            $em->persist($data);
            $em->flush();
            // message flash
            $this->addflash('notice', $id ? ucfirst($translator->trans('admin.flash_message.daily.edit_daily')) : ucfirst($translator->trans('admin.flash_message.daily.new_daily')));
            //exit;
            // redirection
            return $this->redirectToRoute('daily.index');
        }
        return $this->render('admin/daily/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/daily/delete/{id}", name="daily.delete")
     */
    public function deleteAction(ManagerRegistry $doctrine, TranslatorInterface $translator, int $id):Response
    {
        // doctrine
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Daily::class);

        // séléction de l'entité
        $entity = $rc->find($id);

        unlink('img/daily/'.$entity->getImage());
        // dump($entity); exit;
        //suppression
        $em->remove($entity);

        $em->flush();

        $this->addflash('notice', ucfirst($translator->trans('admin.flash_message.daily.delete_daily')) );
        //exit;
        // redirection
        return $this->redirectToRoute('daily.index');
    }

    /**
     * @Route("/daily", name="daily.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc = $doctrine->getRepository(Daily::class);
        $daily = $rc->findAll();
        return $this->render('admin/daily/index.html.twig', [
            'daily' => $daily
        ]);
    }
}
