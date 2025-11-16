<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface; // ✅
use App\Entity\Espacepartage;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Message;



final class EncadController extends AbstractController
{
    #[Route('/encad', name: 'app_encad')]
    public function index(EntityManagerInterface $em,UserRepository $userRepo,MessageRepository $messageRepo): Response
    {
        $encad=$this->getUser();
         $stagiaires = $userRepo->findStagiairesByEncadrant($encad);
         $messages = [];
         foreach ($stagiaires as $stagiaire) {
         $messages[$stagiaire->getId()] = $messageRepo->createQueryBuilder('m')
         ->where(
        '(m.expediteur = :encadrant AND m.destinataire = :stagiaire) OR 
         (m.expediteur = :stagiaire AND m.destinataire = :encadrant)'
    )
    ->setParameter('encadrant', $encad)
    ->setParameter('stagiaire', $stagiaire)
    ->orderBy('m.dateEnvoi', 'ASC') // ou DESC si tu veux les plus récents d'abord
    ->getQuery()
    ->getResult();
        }
       $partages = $em->getRepository(Espacepartage::class)
    ->createQueryBuilder('e')
    ->where('e.destinataire = :encad')
    ->setParameter('encad', $encad)
    ->orderBy('e.dateAjout', 'DESC')
    ->getQuery()
    ->getResult();


        return $this->render('role/encad.html.twig', [
            'controller_name' => 'EncadController',
            'encad' => $encad,
            'stagiaires' => $stagiaires,
             'messages_par_stagiaire' => $messages,
             'partages' => $partages

        ]);
    }

#[Route('/message/envoyer/{idStagiaire}', name: 'app_envoyer_message_encad', methods: ['POST'])]
public function envoyerMessage(
    Request $request,
    UserRepository $userRepo,
    EntityManagerInterface $em,
    int $idStagiaire
): Response {
    $contenu = $request->request->get('contenu');
    $stagiaire = $userRepo->find($idStagiaire);
    $encadrant = $this->getUser();

    $message = new Message();
    $message->setContenu($contenu);
    $message->setExpediteur($encadrant);
    $message->setDestinataire($stagiaire);
    $message->setDateEnvoi(new \DateTime());
    $message->setTypeDiscussion('encadrant');
    $message->setExpireLe(new \DateTime('+7 days'));

    $em->persist($message);
    $em->flush();

    return $this->redirectToRoute('app_encad');
}


}
