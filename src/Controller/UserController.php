<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // ✅ Correct


final class UserController extends AbstractController
{
    #[Route('admin/userForm', name: 'userForm')]
    public function index(Request $request,EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user=new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            // ✅ Encodage du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);


            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('admin/userForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
