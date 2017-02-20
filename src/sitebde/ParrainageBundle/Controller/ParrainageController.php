<?php

namespace sitebde\ParrainageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use sitebde\ParrainageBundle\Entity\EtudiantMatiereFaible;
use sitebde\ParrainageBundle\Entity\EtudiantMatiereForte;
use sitebde\ParrainageBundle\Entity\EtudiantSport;
use sitebde\ParrainageBundle\Entity\EtudiantLoisir;

class ParrainageController extends Controller
{
    public function accueilAction()
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer les 3 étudiants les plus proches de l'étudiant connecté -- Problème : algo de profil-matching
        $tabEtudiants[] = $repositoryEtudiants->findOneByNom('Lanusse');
        $tabEtudiants[] = $repositoryEtudiants->findOneByNom('Sallebert--Menaut');
        $tabEtudiants[] = $repositoryEtudiants->findOneByNom('Martinet');
        
        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:accueil.html.twig', array('etudiantsProposes' => $tabEtudiants, 'etudiants' => $etudiants));
    }
    
    public function listePremieresAnneesAction()
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer tous les étudiants de première année, triés par ordre alphabétique de nom
        $tabEtudiantsPremieresAnnees = $repositoryEtudiants->findByNumAnnee("1", array("nom" => "ASC"));
        
        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:listePremieresAnnees.html.twig', array('etudiantsPremieresAnnees' => $tabEtudiantsPremieresAnnees, 'etudiants' => $etudiants));
    }
    
    public function listeDeuxiemesAnneesAction()
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer tous les étudiants de deuxième année, triés par ordre alphabétique de nom
        $tabEtudiantsDeuxiemesAnnees = $repositoryEtudiants->findByNumAnnee("2", array("nom" => "ASC"));
        
        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:listeDeuxiemesAnnees.html.twig', array('etudiantsDeuxiemesAnnees' => $tabEtudiantsDeuxiemesAnnees, 'etudiants' => $etudiants));
    }
    
    public function detailsProfilAction($idEtudiant)
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();$repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer l'étudiant dont l'id a été passé en paramètre (requête perso pour trier les activités et matières)
        $etudiant = $repositoryEtudiants->getEtudiantLoisirsEtSports($idEtudiant);
        
        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:detailsProfil.html.twig', array('etudiant' => $etudiant, 'etudiants' => $etudiants));
    }
    
    public function profilAction()
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer l'étudiant connecté -- Problème : récupérer l'étudiant connecté et pas Quentin
        $quentin = $repositoryEtudiants->findOneByNom('Lanusse');
        $etudiant = $repositoryEtudiants->getEtudiantLoisirsEtSports($quentin->getId());
        
        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:profil.html.twig', array('etudiant' => $etudiant, 'etudiants' => $etudiants));
    }
    
    public function profilEditionAction()
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');

        $etudiants = $repositoryEtudiants->findAll();

        return $this->render('sitebdeParrainageBundle:Parrainage:profilEdition.html.twig', array('etudiants' => $etudiants));
    }
    
    public function demandeParrainageAction($idEtudiant)
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        /* Supprimer un etudiantLoisir -- Problème : vérifier qu'il l'a */
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        $etudiant = $repositoryEtudiants->findOneByNom('Lanusse');
        $repositoryLoisirs = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Loisir');
        $loisir = $repositoryLoisirs->findOneByLibelle('Animes');
        $repositoryEtudiantLoisirs = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:EtudiantLoisir');
        $etudiantloisir = $repositoryEtudiantLoisirs->findOneBy(array('etudiant' => $etudiant->getId(), 'loisir' => $loisir->getId()));
        
        $gestionnaireEntite->remove($etudiantloisir);
        
        /* Ajouter un etudiantSport -- Problème : vérifier qu'il l'a pas déjà
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        $etudiant = $repositoryEtudiants->findOneByNom('Lanusse');
        $repositorySports = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Sport');
        $sport = $repositorySports->findOneByLibelle('Handball');
        $etudiantsport = new EtudiantSport($etudiant, $sport);
        
        $gestionnaireEntite->persist($etudiantsport); */
        
        $gestionnaireEntite->flush();
        
        return $this->redirect($this->generateUrl('sitebde_parrainage_details_profil', array('idEtudiant' => $idEtudiant)));
    }
    
    public function redirectionVersEtudiantAction()
    {
        $redirection = "non déterminé";
        $nomComplet = $_POST['nomComplet'];
        $tabNomComplet = explode(" ", $nomComplet);

        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
            
        if (! count($tabNomComplet) == 2)
        {
            $prenom = $tabNomComplet[0];
            $nom = $tabNomComplet[1];
    
            $etudiant = $repositoryEtudiants->findOneBy(array(
                "nom" => $nom,
                "prenom" => $prenom));
            
            if ($etudiant != NULL) {
                $idEtudiant = $etudiant->getId();
                $redirection = "accueil";
            }
        }
        if ($redirection == "accueil")
        {
            return $this->redirect($this->generateUrl('sitebde_parrainage_details_profil', array('idEtudiant' => $idEtudiant)));
        }
        else
        {
            return $this->redirect($this->generateUrl('sitebde_parrainage_recherche_sans_resultat'));
        }
    }
    
    public function rechercheSansResultatAction()
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');

        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:rechercheSansResultat.html.twig', array('etudiants' => $etudiants));
    }
}
