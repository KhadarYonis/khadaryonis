<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 02/02/18
 * Time: 11:43
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Carousel;
use AppBundle\Form\CarouselType;
use AppBundle\Form\CategoryType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/admin")
 */
class CarouselController extends Controller
{
    /**
     * @Route("/carousel/form", name="carousel.form", defaults={"id" = null})
     * @Route("/carousel/update/{id}", name="carousel.update")
     */
    public function formAction(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, int $id = null):Response
    {
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Carousel::class);

        $carousel= $id ? $rc->find($id) : new Carousel();

        $type = CarouselType::class;

        $form = $this->createForm($type, $carousel);

        $form->handleRequest($request);

        // valide
        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $file = $form['image']->getData();

            $file->move('img/carousel', $file->getClientOriginalName());

            $data->setImage($file->getClientOriginalName());

            $em->persist($data);
            $em->flush();
            // message flash
            $this->addflash('notice', $id ? ucfirst($translator->trans('admin.flash_message.carousel.edit_carousel')) : ucfirst($translator->trans('admin.flash_message.carousel.new_carousel')));
            //exit;
            // redirection
            return $this->redirectToRoute('carousel.index');
        }
        return $this->render('admin/carousel/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/carousel/delete/{id}", name="carousel.delete")
     */
    public function deleteAction(ManagerRegistry $doctrine, TranslatorInterface $translator, int $id):Response
    {
        // doctrine
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Carousel::class);

        // séléction de l'entité
        $entity = $rc->find($id);

        unlink('img/carousel/'.$entity->getImage());
        // dump($entity); exit;
        //suppression
        $em->remove($entity);

        $em->flush();

        $this->addflash('notice', ucfirst($translator->trans('admin.flash_message.carousel.delete_carousel')) );
        //exit;
        // redirection
        return $this->redirectToRoute('carousel.index');
    }



    /**
     * @Route("/carousel", name="carousel.index")
     */

    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc = $doctrine->getRepository(Carousel::class);
        $carousel = $rc->findAll();

        return $this->render('admin/carousel/index.html.twig', [
            'carousels' => $carousel
        ]);
    }
}