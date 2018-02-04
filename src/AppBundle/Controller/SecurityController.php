<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 02/02/18
 * Time: 23:55
 */


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Translation\TranslatorInterface;

class SecurityController extends  Controller
{
    /**
     * @Route("/login", name="security.login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils, SessionInterface $session, TranslatorInterface $translator)
    {


        // get the login error if there is one
        //$error = $authUtils->getLastAuthenticationError();



        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();


        //dump($error, $lastUsername); exit;
        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername
        ));
    }

    /**
     * @Route("/logout", name="security.logout")
     */
    public function logout()
    {
        // methode non appelé
    }

    /**
     * @Route("/redirect-by-role", name="security.redirect.by.role")
     */
    public function redirectByRole()
    {
        // récupération de l'utilisateur vient extends controll er

        $user = $this->getUser();


        // récupération du rôle get roles vient user entity

        $roles = $user->getRoles();

        //dump($user, $roles);exit;

        // test sur le role

        if(in_array('ROLE_ADMIN', $roles)) {
            return $this->redirectToRoute('admin.homepage.index');
        } else {
            return $this->redirectToRoute('homepage.public.index');
        }
    }


}