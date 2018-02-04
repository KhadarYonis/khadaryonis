<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Item;
use AppBundle\Form\ItemType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/admin")
 */
class ItemController extends Controller
{
    /**
     * @Route("/item/delete/{id}", name="item.delete")
     */
    public function deleteAction(ManagerRegistry $doctrine, TranslatorInterface $translator, int $id):Response
    {
        // doctrine
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Item::class);
        // séléction de l'entité
        $entity = $rc->find($id);

        unlink('img/item/'.$entity->getImage());
        //suppression
        $em->remove($entity);
        $em->flush();
        $this->addflash('notice', $translator->trans('flash_message.item.delete_item') );
        //exit;
        // redirection
        return $this->redirectToRoute('item.index');
    }



    /**
     * @Route("/item/form", name="item.form", defaults={"id" = null})
     * @Route("/item/update/{id}", name="item.update")
     */
    public function formAction(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, int $id = null):Response
    {
        $em = $doctrine->getManager();

        $rc = $doctrine->getRepository(Item::class);

        $item = $id ? $rc->find($id) : new Item();

        $type = ItemType::class;

        $form = $this->createForm($type, $item);

        $form->handleRequest($request);
        // valide
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $file = $form['image']->getData();

            $file->move('img/item', $file->getClientOriginalName());

            $data->setImage($file->getClientOriginalName());

            //dump($data); exit;
            $em->persist($data);
            $em->flush();
            // message flash
            $this->addflash('notice', $id ? $translator->trans('flash_message.item.edit_item') : $translator->trans('flash_message.item.new_item'));
            //exit;
            // redirection
            return $this->redirectToRoute('item.index');
        }
        return $this->render('admin/item/form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/item", name="item.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc = $doctrine->getRepository(Item::class);
        $item = $rc->findAll();

        return $this->render('admin/item/index.html.twig', [
            'items' => $item
        ]);
    }
}
