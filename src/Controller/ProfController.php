<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository; // ✅ Correct
use Doctrine\ORM\EntityManagerInterface; // ✅ Correct
use App\Repository\MessageRepository; // ✅ Correct
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Message;





final class ProfController extends AbstractController
{
    #[Route('/prof', name: 'app_prof')]
    public function index(EntityManagerInterface $em,UserRepository $userRepo,MessageRepository $messageRepo): Response
    {
        $prof= $this->getUser();
        $stagiaires = $userRepo->findStagiairesByProfesseur($prof);

        $messages_prof = [];
        $messages_encad = [];
        foreach ($stagiaires as $stagiaire) {
        $messages_prof[$stagiaire->getId()] =$messageRepo->createQueryBuilder('m')
            ->where('(m.expediteur = :professeur AND m.destinataire = :stagiaire) OR (m.expediteur = :stagiaire AND m.destinataire = :professeur)')
            ->setParameter( 'professeur' ,$prof)
            ->setParameter('stagiaire', $stagiaire)
            ->orderBy('m.dateEnvoi', 'ASC')
            ->getQuery()
            ->getResult();
        }
        foreach ($stagiaires as $stagiaire) {
            $encadrant = $stagiaire->getStage()?->getEncadrant();
            if (!$encadrant) {
             $messages_encad[$stagiaire->getId()] = []; // vide si pas d'encadrant
             continue;
            }
            $messages_encad[$stagiaire->getId()] =$messageRepo->createQueryBuilder('m')
            ->where('(m.expediteur = :encadrant AND m.destinataire = :stagiaire) OR (m.expediteur = :stagiaire AND m.destinataire = :encadrant)')
->setParameter('encadrant', $encadrant)
->setParameter('stagiaire', $stagiaire)
            ->orderBy('m.dateEnvoi', 'ASC')
            ->getQuery()
            ->getResult();
}

        return $this->render('role/prof.html.twig', [
            'controller_name' => 'ProfController',
            'messages_prof' => $messages_prof,
            'messages_encad' => $messages_encad,
            'stagiaires' => $stagiaires,
            'prof'=> $prof
        ]);
    }
    #[Route('/envoyer-message/{idStagiaire}', name: 'app_envoyer_message', methods: ['POST'])]
public function envoyerMessage(
    int $idStagiaire,
    Request $request,
    EntityManagerInterface $em,
    UserRepository $userRepo
): Response {
    $contenu = $request->request->get('contenu');
    $stagiaire = $userRepo->find($idStagiaire);

     $message = new Message();
    $message->setContenu($contenu);
    $message->setExpediteur($this->getUser());
    $message->setDestinataire($stagiaire);
    $message->setDateEnvoi(new \DateTime());
    $message->setTypeDiscussion('professeur'); 
    $message->setExpireLe(new \DateTime('+7 days'));

    

    $em->persist($message);
    $em->flush();

    return $this->redirectToRoute('app_prof'); // ou autre selon ton interface
}

#[Route('/professeur/message/{id}/delete', name: 'message_delete', methods: ['POST'])]
    public function deleteMessage(Request $request, ?Message $message, EntityManagerInterface $em): Response
    {
        if (!$message) {
            throw $this->createNotFoundException('Message non trouvé.');
        }

        if ($this->isCsrfTokenValid('delete_message_' . $message->getId(), $request->request->get('_token'))) {
            $em->remove($message);
            $em->flush();
            $this->addFlash('success', 'Message supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide.');
        }

        // Remplace par la route vers la page où tu affiches la messagerie
        return $this->redirectToRoute('app_professeur'); 
    }

}
