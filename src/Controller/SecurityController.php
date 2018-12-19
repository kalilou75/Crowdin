<?php

namespace App\Controller;

use App\Form\ConnexionType;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;

Use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     *  @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager){
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }
        
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ] );
    }

    /**
     *  @Route("/connexion", name="security_login")
     */
    public function login(){
        return $this->render('security/login.html.twig'); 
    }
    /**
     *  @Route("/connexion_succes", name="security_login_succes")
     */
    public function login_succes(){
        return $this->render('security/login_succes.html.twig');
    }
}
