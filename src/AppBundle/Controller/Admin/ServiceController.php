<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Service;
use AppBundle\Form\ServiceType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/admin")
 */
class ServiceController extends Controller
{
    /**
     * @Route("/service/delete/{id}", name="service.delete")
     */
    public function deleteAction(ManagerRegistry $doctrine, TranslatorInterface $translator, int $id):Response
    {
        // doctrine
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Service::class);

        // séléction de l'entité
        $entity = $rc->find($id);

        unlink('img/service/'.$entity->getImage());
        // dump($entity); exit;
        //suppression
        $em->remove($entity);

        $em->flush();

        $this->addflash('notice', ucfirst($translator->trans('admin.flash_message.service.delete_service')) );
        //exit;
        // redirection
        return $this->redirectToRoute('service.index');
    }



    /**
     * @Route("/service/form", name="service.form", defaults={"id" = null})
     * @Route("/service/update/{id}", name="service.update")
     */
    public function formAction(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, int $id = null):Response
    {
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Service::class);

        $service = $id ? $rc->find($id) : new Service();

        $type = ServiceType::class;

        $form = $this->createForm($type, $service);

        $form->handleRequest($request);

        // valide
        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $file = $form['image']->getData();

            $file->move('img/service', $file->getClientOriginalName());

            $data->setImage($file->getClientOriginalName());

            $em->persist($data);
            $em->flush();
            // message flash
            $this->addflash('notice', $id ? ucfirst($translator->trans('admin.flash_message.service.edit_service')) : ucfirst($translator->trans('admin.flash_message.service.new_service')));
            //exit;
            // redirection
            return $this->redirectToRoute('service.index');
        }
        return $this->render('admin/service/form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/service", name="service.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc = $doctrine->getRepository(Service::class);

        $services = $rc->findAll();

        return $this->render('admin/service/index.html.twig', [
            'services' => $services
        ]);
    }
}
