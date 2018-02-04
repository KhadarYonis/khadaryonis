<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/admin")
 */
class ContactController extends Controller
{

    /**
     * @Route("/contact/delete/{id}", name="contact.delete")
     */
    public function deleteAction(ManagerRegistry $doctrine, TranslatorInterface $translator, int $id):Response
    {
        // doctrine
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Contact::class);

        // séléction de l'entité
        $entity = $rc->find($id);


        //suppression
        $em->remove($entity);

        $em->flush();

        $this->addflash('notice', ucfirst($translator->trans('admin.flash_message.contact.delete_contact')) );
        //exit;
        // redirection
        return $this->redirectToRoute('contact.index');
    }

    /**
     * @Route("/contact/form", name="contact.form", defaults={"id" = null})
     * @Route("/contact/update/{id}", name="contact.update")
     */
    public function formAction(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, int $id = null):Response
    {
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Contact::class);

        $service = $id ? $rc->find($id) : new Contact();

        $type = ContactType::class;

        $form = $this->createForm($type, $service);

        $form->handleRequest($request);

        // valide
        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();


            $em->persist($data);
            $em->flush();
            // message flash
            $this->addflash('notice', $id ? ucfirst($translator->trans('admin.flash_message.contact.edit_contact')) : ucfirst($translator->trans('admin.flash_message.contact.new_contact')));
            //exit;
            // redirection
            return $this->redirectToRoute('contact.index');
        }
        return $this->render('admin/contact/form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/contact", name="contact.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc = $doctrine->getRepository(Contact::class);

        $contact = $rc->findAll();

        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $contact
        ]);
    }
}