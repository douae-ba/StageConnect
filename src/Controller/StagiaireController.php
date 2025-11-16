<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\User;
use App\Entity\Message;
use App\Entity\Espacepartage;



final class StagiaireController extends AbstractController
{
    #[Route('/Stagiaire', name: 'app_stagiaire')]
    public function index(UserRepository $userRepository, MessageRepository $messageRepository,EntityManagerInterface $em): Response
    {
        $stagiaire = $this->getUser();

        if (!$stagiaire) {
            throw $this->createAccessDeniedException('Utilisateur non connecté.');
        }

         $partages = $em->getRepository(Espacepartage::class)->findBy([
        'ajouteePar' => $stagiaire
    ]);
        $stage = $stagiaire->getStage();
        $encadrant = $userRepository->findEncadrant($stage);
        $professeur = $userRepository->findProfesseur($stage);

        // Messages avec l'encadrant
        $messagesEncadrant = $messageRepository->createQueryBuilder('m')
            ->where('m.typeDiscussion = :type')
            ->andWhere('(m.expediteur = :stagiaire AND m.destinataire = :encadrant) OR (m.expediteur = :encadrant AND m.destinataire = :stagiaire)')
            ->andWhere('m.expirele IS NULL OR m.expirele > :now') 
            ->setParameter('type' , 'encadrant')
            ->setParameter('stagiaire', $stagiaire)
            ->setParameter('encadrant', $encadrant)
            ->setParameter('now', new \DateTime())
            ->orderBy('m.dateEnvoi', 'ASC')
            ->getQuery()
            ->getResult();

        // Messages avec le professeur
        $messagesProfesseur = $messageRepository->createQueryBuilder('m')
            ->where('m.typeDiscussion = :type')
            ->andWhere('(m.expediteur = :stagiaire AND m.destinataire = :professeur) OR (m.expediteur = :professeur AND m.destinataire = :stagiaire)')
            ->andWhere('m.expirele IS NULL OR m.expirele > :now')
            ->setParameter('type', 'professeur')
    ->setParameter('stagiaire', $stagiaire)
    ->setParameter('professeur', $professeur)
    ->setParameter('now', new \DateTime())
            ->orderBy('m.dateEnvoi', 'ASC')
            ->getQuery()
            ->getResult();
            

        return $this->render('role/stagiaire.html.twig', [
            'stagiaire' => $stagiaire,
            'encadrant' => $encadrant,
            'professeur' => $professeur,
            'messages_encadrant' => $messagesEncadrant,
            'messages_professeur' => $messagesProfesseur,
            'partages' => $partages,
        ]);
    }



    #[Route('/stagiaire/envoyer-message', name: 'stagiaire_envoyer_message', methods: ['POST'])]
public function envoyerMessage(Request $request, EntityManagerInterface $em): RedirectResponse
{
    $user = $this->getUser();
    if (!$user) {
        throw $this->createAccessDeniedException();
    }

    $contenu = $request->request->get('contenu');
    $destinataireId = $request->request->get('destinataire_id');
    $typeDiscussion = $request->request->get('typeDiscussion');

    if (!$contenu || !$destinataireId || !$typeDiscussion) {
        $this->addFlash('error', 'Message incomplet.');
        return $this->redirectToRoute('app_stagiaire');
    }

    $destinataire = $em->getRepository(User::class)->find($destinataireId);
    if (!$destinataire) {
        $this->addFlash('error', 'Destinataire introuvable.');
        return $this->redirectToRoute('app_stagiaire');
    }

    $message = new Message();
    $message->setContenu($contenu);
    $message->setExpediteur($user);
    $message->setDestinataire($destinataire);
    $message->setDateEnvoi(new \DateTime());
    $message->setExpireLe((new \DateTime())->modify('+4 days'));
    $message->setTypeDiscussion($typeDiscussion);

    $em->persist($message);
    $em->flush();

    return $this->redirectToRoute('app_stagiaire');
}



#[Route('/stagiaire/upload', name: 'stagiaire_upload', methods: ['POST'])]
public function upload(Request $request, EntityManagerInterface $em): RedirectResponse
{
    $user = $this->getUser();
    if (!$user) {
        throw $this->createAccessDeniedException('Utilisateur non connecté.');
    }

    $fichier = $request->files->get('fichier');
    $titre = $request->request->get('titre');
    $type = $request->request->get('typeDiscussion');
    $destinataireId = $request->request->get('destinataire_id');

    if( !$fichier || !$destinataireId || !$titre ) {
        $this->addFlash('error','fichier ou destinataire manquant.');
        return $this->redirectToRoute('app_stagiaire');
    }
    $destinataire = $em->getRepository(User::class)->find($destinataireId);
    if (!$destinataire) {
        $this->addFlash('error', 'Destinataire introuvable.');
        return $this->redirectToRoute('app_stagiaire');
    }  
    if ($fichier) {
        $nomFichier = uniqid() . '.' . $fichier->guessExtension();
        $fichier->move($this->getParameter('dossiers_directory'), $nomFichier);

        $partage = new Espacepartage();
        $partage->setTitre($titre);
        $partage->setLien($nomFichier);
        $partage->setDestinataire($destinataire);

        $partage->setAjouteePar($user); // 👈 on utilise l’utilisateur connecté
        $partage->setDateAjout(new \DateTime());

        $em->persist($partage);
        $em->flush();
    }

    return $this->redirectToRoute('app_stagiaire');
}
#[Route('/stagiaire/message/{id}/delete', name: 'message_delete', methods: ['POST'])]
public function deleteMessage(Request $request, Message $message, EntityManagerInterface $em): Response
{
    if ($this->isCsrfTokenValid('delete_message_' . $message->getId(), $request->request->get('_token'))) {
        $em->remove($message);
        $em->flush();
    }

    return $this->redirectToRoute('app_stagiaire'); // adapte cette route à ta page actuelle
}



}
