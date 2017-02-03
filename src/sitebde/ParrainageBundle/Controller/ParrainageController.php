<?php

namespace sitebde\ParrainageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ParrainageController extends Controller
{
    public function accueilAction()
    {
        return $this->render('sitebdeParrainageBundle:Parrainage:accueil.html.twig');
    }
    
    public function listePremieresAnneesAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer les repositories de l'entité Etudiant
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer tous les étudiants de première année
        $tabEtudiants = $repositoryEtudiants->findByNumAnnee("1", array("nom" => "ASC"));
        
        return $this->render('sitebdeParrainageBundle:Parrainage:listePremieresAnnees.html.twig', array('etudiants' => $tabEtudiants));
    }
    
    public function listeDeuxiemesAnneesAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer les repositories de l'entité Etudiant
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer tous les étudiants de première année
        $tabEtudiants = $repositoryEtudiants->findByNumAnnee("2", array("nom" => "ASC"));
        
        return $this->render('sitebdeParrainageBundle:Parrainage:listeDeuxiemesAnnees.html.twig', array('etudiants' => $tabEtudiants));
    }
    
    public function detailsProfilAction($idEtudiant)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer les repositories de l'entité Etudiant
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer l'étudiant
        $etudiant = $repositoryEtudiants->getEtudiantLoisirsEtSports($idEtudiant);
        
        return $this->render('sitebdeParrainageBundle:Parrainage:detailsProfil.html.twig', array('etudiant' => $etudiant));
    }
    
    public function profilAction()
    {
        return $this->render('sitebdeParrainageBundle:Parrainage:profil.html.twig');
    }
}
