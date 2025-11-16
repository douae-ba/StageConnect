<?php
// src/Controller/StageController.php

namespace App\Controller;

use App\Form\StageType;
use App\Entity\Stage;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class StageController extends AbstractController
{
    #[Route('/admin/stageForm', name: 'stageForm')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(StageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();

        $user=new User();
        $user->setNom($data['Nom']);
        $user->setPrenom($data['Prenom']);
        $user->setEmail($data['Email']);
        $user->setPassword(
            password_hash($data['password'], PASSWORD_BCRYPT)
        );

        $stage=new Stage();
        $stage->setEncadrant($data['Encadrant']);
        $stage->setProfesseur($data['Professeur']);
        $stage->setDateDebut($data['dateDebut']);
        $stage->setDateFin($data['dateFin']);
        $stage->setSujet($data['Sujet']);
        $stage->setEtablissement($data['Etablissement']);

        $user->setStage($stage);

        $em->persist($stage);
        $em->persist($user);
        $em->flush();

         $this->addFlash('success', 'Formulaire soumis avec succès !');
         return $this->redirectToRoute('app_admin');

        }

        return $this->render('admin/stageForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
