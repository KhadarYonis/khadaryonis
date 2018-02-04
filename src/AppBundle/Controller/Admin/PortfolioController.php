<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Portfolio;
use AppBundle\Form\PortfolioType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/admin")
 */
class PortfolioController extends Controller
{
    /**
     * @Route("/portfolio/delete/{id}", name="portfolio.delete")
     */
    public function deleteAction(ManagerRegistry $doctrine, TranslatorInterface $translator, int $id):Response
    {
        // doctrine
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Portfolio::class);
        // séléction de l'entité
        $entity = $rc->find($id);
        //suppression
        $em->remove($entity);
        $em->flush();
        $this->addflash('notice', $translator->trans('flash_message.portfolio.delete_portfolio') );
        //exit;
        // redirection
        return $this->redirectToRoute('portfolio.index');
    }



    /**
     * @Route("/portfolio/form", name="portfolio.form", defaults={"id" = null})
     * @Route("/portfolio/update/{id}", name="portfolio.update")
     */
    public function formAction(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, int $id = null):Response
    {
        $em = $doctrine->getManager();

        $rc = $doctrine->getRepository(Portfolio::class);

        $item = $id ? $rc->find($id) : new Portfolio();

        $type = PortfolioType::class;

        $form = $this->createForm($type, $item);

        $form->handleRequest($request);
        // valide
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();


            //dump($data); exit;
            $em->persist($data);
            $em->flush();
            // message flash
            $this->addflash('notice', $id ? $translator->trans('flash_message.portfolio.edit_portfolio') : $translator->trans('flash_message.portfolio.new_portfolio'));
            //exit;
            // redirection
            return $this->redirectToRoute('portfolio.index');
        }
        return $this->render('admin/portfolio/form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/portfolio", name="portfolio.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {
        $rc = $doctrine->getRepository(Portfolio::class);
        $portfolio = $rc->findAll();

        return $this->render('admin/portfolio/index.html.twig', [
            'portfolios' => $portfolio
        ]);
    }
}
