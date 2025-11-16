<?php


// src/Controller/AdminController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\StageRepository;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\StageType;
use App\Form\stageditType;
use App\Entity\Stage;





class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UserRepository $userRepository,StageRepository $stageRepository,
        UserRepository $encadrantRepository): Response
{
    $users = $userRepository->findAll();

    $stagiaires = array_filter($users, function ($user) {
        return in_array('ROLE_STAGIAIRE', $user->getRoles());
    });
    $encadrants = array_filter($users, function ($user) {
            return in_array('ROLE_ENCADRANT', $user->getRoles());
        });
        

    return $this->render('admin/index.html.twig', [
        'stagiaires' => $userRepository->findByRoles('ROLE_STAGIAIRE'),
        'total_stagiaires' => count($stagiaires),
        'stagiaires_ce_mois' => $stageRepository->countThisMonth(),
        'total_encadrants' => count($encadrants),
        'stages_en_cours' => $stageRepository->countEnCours(),
        'stages_a_venir' => $stageRepository->countAVenir(),
    ]);
}

       
         
    // Supprimer un stagiaire
#[Route('/admin/{id}/delete', name: 'stagiaire_delete', methods: ['POST'])]
public function delete(Request $request, User $stagiaire, EntityManagerInterface $em): Response
{
     if (!$stagiaire) {
        throw $this->createNotFoundException('Stagiaire non trouvé.');
    }
    if ($this->isCsrfTokenValid('delete' . $stagiaire->getId(), $request->request->get('_token'))) {
        $em->remove($stagiaire);
        $em->flush();
    }

    return $this->redirectToRoute('app_admin');
}


}
