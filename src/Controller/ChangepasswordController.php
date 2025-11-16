<?php

namespace App\Controller;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface; 
use Psr\Container\ContainerInterface; 
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


final class ChangepasswordController extends AbstractController
{
    #[Route('/changepassword', name: 'app_changepassword')]
    public function index(Request $request,UserPasswordHasherInterface$passwordHasher,EntityManagerInterface $em,ContainerInterface $container): Response
    {
    $user = $this->getUser(); // ✔️ Fonctionne dans AbstractController
        if(!$user) {
            return $this->redirectToRoute('app_login');
        }

        if($request->isMethod('POST')){
            $ancien=$request->request->get('ancien');
            $nouveau=$request->request->get('nouveau');
            $confirm=$request->request->get('confirm');

            if(!$passwordHasher->isPasswordValid($user,$ancien)){
                $this->addFlash('error','l\'ancien mot de passe incorrect');
            }elseif($nouveau!==$confirm){
                $this->addFlash('error','les mots de passe ne correspondent pas.');
            }else{
                $hashedPassword = $passwordHasher->hashPassword($user, $nouveau);
                $user->setPassword($hashedPassword);
                $em->flush();

                $this->addFlash('success', 'Mot de passe mis à jour avec succès.');
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('changepassword/index.html.twig', [
            'controller_name' => 'ChangepasswordController',
        ]);
    }
}
