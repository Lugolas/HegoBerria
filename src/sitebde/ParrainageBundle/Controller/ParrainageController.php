<?php

namespace sitebde\ParrainageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Ldap\LdapClient;

use sitebde\ParrainageBundle\Entity\EtudiantMatiereFaible;
use sitebde\ParrainageBundle\Entity\EtudiantMatiereForte;
use sitebde\ParrainageBundle\Entity\EtudiantSport;
use sitebde\ParrainageBundle\Entity\EtudiantLoisir;
use sitebde\ParrainageBundle\Entity\Etudiant;
use sitebde\ParrainageBundle\Entity\DemandeParrainage;
use sitebde\ParrainageBundle\Entity\Lien;

use sitebde\ParrainageBundle\Form\EtudiantType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ParrainageController extends Controller
{
    public function accueilAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupérer l'étudiant connecté
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $entiteEtudiantConnecte = $repositoryEtudiants->find($etudiantConnecte['id']);
            
            // Récupérer tous les étudiants de l'autre année
            if ($etudiantConnecte['numAnnee'] == 1)
            {
                $autreAnnee = 2;
            }
            else
            {
                $autreAnnee = 1;
            }
            $etudiantsAutreAnnee = $repositoryEtudiants->getAllParAnnee($autreAnnee);
            
            // Récupérer les 3 (au max) étudiants de l'autre année les plus en accord avec l'étudiant connecté
            $tabEtudiantsProposes = $this->propositionsEtudiants($etudiantsAutreAnnee, $entiteEtudiantConnecte, 3);
            

            // Afficher la page
            return $this->render('sitebdeParrainageBundle:Parrainage:accueil.html.twig', array( 'etudiantsProposes' => $tabEtudiantsProposes,
                                                                                                'etudiantConnecte'  => $etudiantConnecte));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }

    }
    
    public function mentionsLegalesAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer toutes les infos pour le menu
        $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
        $tabInfos = $repositoryInformations->getInformationsTriees();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:mentionsLegales.html.twig',
               array('etudiantConnecte' => $etudiantConnecte));
    }
    
   
    /* ******************************************************************************************************************
       *******************************************     Partie Profil     ************************************************
       ****************************************************************************************************************** */
    
    
    public function profilAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupérer l'étudiant connecté et ses détails avec une requête personnalisée
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $etudiantDetaille = $repositoryEtudiants->getEtudiantLoisirsEtSports($etudiantConnecte['id']);
            
            // Afficher la page
            return $this->render('sitebdeParrainageBundle:Parrainage:profil.html.twig', array('etudiant' => $etudiantDetaille,
                                                                                              'etudiantConnecte' => $etudiantConnecte));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function profilEditionAction(Request $requeteUtilisateur)
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupérer l'étudiant connecté
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $entiteEtudiantConnecte = $repositoryEtudiants->find($etudiantConnecte['id']);
            
            // Mettre à jour sa photo pour l'upload et la miniature
            $photoInitiale = $entiteEtudiantConnecte->getPhoto();
            $entiteEtudiantConnecte->setImageFile(new File($this->getParameter('photos_etudiants_dossier').$photoInitiale));
            
            // Construire le formulaire et le gérer
            $formulaire = $this->createForm(new EtudiantType, $entiteEtudiantConnecte);
            
            
            $formulaire->handleRequest($requeteUtilisateur);
            
            // Si le formulaire a été soumis et qu'il est valide
            if ($formulaire->isValid())
            {
                // Récupérer les répositorys d'Etudiant et ceux liés
                $repositoryEtudiantMatiereFaibles = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:EtudiantMatiereFaible');
                $repositoryEtudiantMatiereFortes = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:EtudiantMatiereForte');
                $repositoryEtudiantLoisirs = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:EtudiantLoisir');
                $repositoryEtudiantSports = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:EtudiantSport');
                $repositoryLiens = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Lien');
                
                // Récupérer les critères de l'étudiant
                $etudiantMatiereFaibles = $repositoryEtudiantMatiereFaibles->getEtudiantMatiereFaibleParEtudiant($etudiantConnecte['id']);
                $etudiantMatiereFortes = $repositoryEtudiantMatiereFortes->getEtudiantMatiereFortesParEtudiant($etudiantConnecte['id']);
                $etudiantLoisirs = $repositoryEtudiantLoisirs->getEtudiantLoisirsParEtudiant($etudiantConnecte['id']);
                $etudiantSports = $repositoryEtudiantSports->getEtudiantSportParEtudiant($etudiantConnecte['id']);
                $liens = $repositoryLiens->getLienParEtudiant($etudiantConnecte["id"]);
                
                
                // Suppression de la liste des matières faibles de l'étudiant
                foreach ($etudiantMatiereFaibles as $uneMatiereFaible)
                {
                    $gestionnaireEntites->remove($uneMatiereFaible);
                }
                
                // Suppression de la liste des matières fortes de l'étudiant
                foreach ($etudiantMatiereFortes as $uneMatiereForte)
                {
                    $gestionnaireEntites->remove($uneMatiereForte);
                }
                
                // Suppression de la liste des loisirs de l'étudiant
                foreach ($etudiantLoisirs as $unLoisir)
                {
                    $gestionnaireEntites->remove($unLoisir);
                }
                
                // Suppression de la liste des sports de l'étudiant
                foreach ($etudiantSports as $unSport)
                {
                    $gestionnaireEntites->remove($unSport);
                }
                
                // Suppression de la liste des liens de l'étudiant
                foreach ($liens as $unLien)
                {
                    $gestionnaireEntites->remove($unLien);
                }
                
                // *) Si la photo initiale était celle de base, la sauvegarder ailleurs (elle serait supprimée sinon)
                if ($photoInitiale == "user.png")
                {
                    $fileSystem = new Filesystem();
                    $fileSystem->copy($this->getParameter('photos_etudiants_dossier')."user.png", "user.png");
                }
                
                foreach($entiteEtudiantConnecte->getLiens() as $lien)
                {
                    $lien->setEtudiant($entiteEtudiantConnecte);
                }
                
                // Enregistrer les modifications
                $gestionnaireEntites->persist($entiteEtudiantConnecte);
                $gestionnaireEntites->flush();
                
                // *) Puis la restaurer
                if ($photoInitiale == "user.png")
                {
                    $fileSystem->copy("user.png", $this->getParameter('photos_etudiants_dossier')."user.png");
                    $fileSystem->remove("user.png");
                }
                
                // Rediriger vers le profil
                return $this->redirect($this->generateUrl('sitebde_parrainage_profil'));
            }
            
            $infosAffichage = array();
            
            // Récupérer les éléments nécessaires à l'organisation des listes de cases à cocher Matiere
            $repositoryMatieres = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Matiere');
            $matieres = $repositoryMatieres->findAll();
            $tabIdMatieres = array();
            foreach($matieres as $matiere)
            {
                $tabIdMatieres[] = $matiere->getId();
                $infosAffichage['matieres'][$matiere->getId()] = array('categorie' => $matiere->getCategorie());
            }
            $infosAffichage['idsMatieres'] = array('min' => min($tabIdMatieres), 'max' => max($tabIdMatieres));
            
            // Récupérer les éléments nécessaires à l'organisation de la liste de cases à cocher Loisirs
            $repositoryLoisirs = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Loisir');
            $loisirs = $repositoryLoisirs->findAll();
            $tabIdLoisirs = array();
            foreach($loisirs as $loisir)
            {
                $tabIdLoisirs[] = $loisir->getId();
                $infosAffichage['loisirs'][$loisir->getId()] = array('categorie' => $loisir->getCategorie());
            }
            $infosAffichage['idsLoisirs'] = array('min' => min($tabIdLoisirs), 'max' => max($tabIdLoisirs));
            
            // Récupérer les éléments nécessaires à l'organisation de la liste de cases à cocher Sports
            $repositorySports = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Sport');
            $sports = $repositorySports->findAll();
            $tabIdSports = array();
            foreach($sports as $sport)
            {
                $tabIdSports[] = $sport->getId();
                $infosAffichage['sports'][$sport->getId()] = array('categorie' => $sport->getCategorie());
            }
            $infosAffichage['idsSports'] = array('min' => min($tabIdSports), 'max' => max($tabIdSports));

            
            $infosAffichageJSON = json_encode($infosAffichage);

            return $this->render('sitebdeParrainageBundle:Parrainage:formulaireProfil.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                        'etudiantConnecte' => $etudiantConnecte,
                                                                                                        'infosAffichageJSON' => $infosAffichageJSON));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
        
    }
    
    public function ajouterCommentaireSportAction($id)
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            extract($_POST);
            
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            $repositoryEtudiantSport = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:EtudiantSport');
            
            $etudiantSport = $repositoryEtudiantSport->findOneById($id);
            
            $etudiantSport->setCommentaire($commentaire);
            
            $gestionnaireEntites->persist($etudiantSport);
            $gestionnaireEntites->flush();
            
            return $this->redirect($this->generateUrl('sitebde_parrainage_profil'));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function ajouterCommentaireLoisirAction($id)
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            extract($_POST);
            
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            $repositoryEtudiantLoisirs = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:EtudiantLoisir');
            
            $etudiantLoisir = $repositoryEtudiantLoisirs->findOneById($id);
            
            $etudiantLoisir->setCommentaire($commentaire);
            
            $gestionnaireEntites->persist($etudiantLoisir);
            $gestionnaireEntites->flush();
            
            return $this->redirect($this->generateUrl('sitebde_parrainage_profil'));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    
    /* ******************************************************************************************************************
       **************************************     Partie Autres étudiants     *******************************************
       ****************************************************************************************************************** */
    
    
    public function listePremieresAnneesAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupérer tous les étudiants de première année
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $tabEtudiantsPremieresAnnees = $repositoryEtudiants->getAllParAnnee('1');
            
            // Récupérer l'étudiant connecté
            $entiteEtudiantConnecte = $repositoryEtudiants->find($etudiantConnecte['id']);
            
            // Trier les étudiants de première année selon les affinités
            $tabEtudiantsPremieresAnnees = $this->rechercheCriteres($tabEtudiantsPremieresAnnees, 
                                                                    $entiteEtudiantConnecte->getEtudiantMatiereFortes(),
                                                                    $entiteEtudiantConnecte->getEtudiantMatiereFaibles(),
                                                                    $entiteEtudiantConnecte->getLoisirsAssocies(),
                                                                    $entiteEtudiantConnecte->getSportsAssocies(),
                                                                    true);
            
            
            // Afficher la page
            return $this->render('sitebdeParrainageBundle:Parrainage:listeEtudiants.html.twig', array('tabEtudiants' => $tabEtudiantsPremieresAnnees,
                                                                                                      'anneeEtudiants' => 1,
                                                                                                      'etudiantConnecte' => $etudiantConnecte));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function listeDeuxiemesAnneesAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupérer tous les étudiants de deuxième année
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $tabEtudiantsDeuxiemesAnnees = $repositoryEtudiants->getAllParAnnee('2');
            
            // Récupérer l'étudiant connecté
            $entiteEtudiantConnecte = $repositoryEtudiants->find($etudiantConnecte['id']);
            
            // Trier les étudiants de deuxième année selon les affinités
            $tabEtudiantsDeuxiemesAnnees = $this->rechercheCriteres($tabEtudiantsDeuxiemesAnnees, 
                                                                    $entiteEtudiantConnecte->getEtudiantMatiereFortes(),
                                                                    $entiteEtudiantConnecte->getEtudiantMatiereFaibles(),
                                                                    $entiteEtudiantConnecte->getLoisirsAssocies(),
                                                                    $entiteEtudiantConnecte->getSportsAssocies(),
                                                                    true);
            
            // Afficher la page
            return $this->render('sitebdeParrainageBundle:Parrainage:listeEtudiants.html.twig', array('tabEtudiants' => $tabEtudiantsDeuxiemesAnnees,
                                                                                                      'anneeEtudiants' => 2,
                                                                                                      'etudiantConnecte' => $etudiantConnecte));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function detailsProfilAction($idEtudiant)
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupérer l'étudiant dont l'id a été passé en paramètre et ses détails avec une requête personnalisée
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $etudiant = $repositoryEtudiants->getEtudiantLoisirsEtSports($idEtudiant);
            
            // Vérifier qu'une demande ne lie pas déjà les deux étudiants
            $repositoryDemandes = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:DemandeParrainage');
            $demandeDepuisEtudiantSelectionne = $repositoryDemandes->findOneBy(array('etudiantDemandeur' => $etudiantConnecte['id'], 'etudiantDemande' => $etudiant[0]->getId()));
            $demandeDepuisEtudiantConnecte = $repositoryDemandes->findOneBy(array('etudiantDemandeur' => $etudiant[0]->getId(), 'etudiantDemande' => $etudiantConnecte['id']));
            $demandeDejaExistante = ($demandeDepuisEtudiantConnecte || $demandeDepuisEtudiantSelectionne);
            
            // Afficher la page
            return $this->render('sitebdeParrainageBundle:Parrainage:detailsProfil.html.twig', array('etudiant' => $etudiant,
                                                                                                     'etudiantConnecte' => $etudiantConnecte,
                                                                                                     'demandeDejaExistante' => $demandeDejaExistante));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    
    /* ******************************************************************************************************************
       ******************************************     Partie Demandes     ***********************************************
       ****************************************************************************************************************** */
    
    
    public function demandesAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupérer l'étudiant connecté
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');

            // Récupérer toutes les demandes de l'étudiant connecté
            $etudiantDemandes = $repositoryEtudiants->getDemandesParrainage($etudiantConnecte['id']);
            
            // Afficher la page
            return $this->render('sitebdeParrainageBundle:Parrainage:demandes.html.twig', array('etudiantDemandes' => $etudiantDemandes,
                                                                                                'etudiantConnecte' => $etudiantConnecte));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function demandeParrainageAction($idEtudiant)
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupérer l'étudiant connecté
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $entiteEtudiantConnecte = $repositoryEtudiants->find($etudiantConnecte['id']);
            
            // Récupérer l'étudiant dont l'id a été passé en paramètre
            $autreEtudiant = $repositoryEtudiants->find($idEtudiant);
            
            // Créer une nouvelle demande de parrainage entre les deux étudiants, non acceptée
            $demande = new DemandeParrainage($entiteEtudiantConnecte, $autreEtudiant, false);
            
            // Enregistrer la nouvelle demande
            $gestionnaireEntites->persist($demande);
            $gestionnaireEntites->flush();
            
            // Rediriger vers la page des demandes
            return $this->redirect($this->generateUrl('sitebde_parrainage_demandes'));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function accepterDemandeAction($idDemande)
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupérer la demande à accepter
            $repositoryDemandes = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:DemandeParrainage');
            $demandeAcceptee = $repositoryDemandes->find($idDemande);
            
            // L'accepter
            $demandeAcceptee->setEstAcceptee(true);
            
            // Récupérer les deux étudiants entre qui le lien est créé
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $etudiant1 = $demandeAcceptee->getEtudiantDemandeur();
            $etudiant2 = $demandeAcceptee->getEtudiantDemande();
            
            // Augmenter de 1 leur nombre de demandes validées
            $etudiant1->setNbDemandesValidees($etudiant1->getNbDemandesValidees() + 1);
            $etudiant2->setNbDemandesValidees($etudiant2->getNbDemandesValidees() + 1);
            
            // Enregistrer les modifications
            $gestionnaireEntites->persist($demandeAcceptee);
            $gestionnaireEntites->flush();
            
            // Supprimer les demandes devenues éventuellement excédentaires pour l'étudiant demandeur
            $etudiantDemandeur = $demandeAcceptee->getEtudiantDemandeur();
            $this->supprimerDemandesExcedentaires($etudiantDemandeur);
            
            // Supprimer les demandes devenues éventuellement excédentaires pour l'étudiant demandé
            $etudiantDemande = $demandeAcceptee->getEtudiantDemande();
            $this->supprimerDemandesExcedentaires($etudiantDemande);
            
            // Rediriger vers la page des demandes
            return $this->redirect($this->generateUrl('sitebde_parrainage_demandes'));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    private function supprimerDemandesExcedentaires($etudiant)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer les demandes faites et reçues par l'étudiant
        $repositoryDemandes = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:DemandeParrainage');
        $tabDemandesFaitesEtudiant = $etudiant->getDemandesFaites();
        $tabDemandesRecuesEtudiant = $etudiant->getDemandesRecues();
        
        // Si l'étudiant est en première année, il ne peut avoir qu'un parrain, donc tout supprimer
        if ($etudiant->getNumAnnee() == 1)
        {
            // Supprimer toutes les demandes faites, sauf celle qui est acceptée éventuellement
            foreach ($tabDemandesFaitesEtudiant as $demande)
            {
                if ($demande->getEstAcceptee() == false)
                {
                    $gestionnaireEntites->remove($demande);
                }
            }
            
            // Supprimer toutes les demandes reçues, sauf celle qui est acceptée éventuellement
            foreach ($tabDemandesRecuesEtudiant as $demande)
            {
                if ($demande->getEstAcceptee() == false)
                {
                    $gestionnaireEntites->remove($demande);
                }
            }
        }
        // S'il est en deuxième année et qu'il a au moins 2 filleuls, tout supprimer
        else if ($etudiant->getNbDemandesValidees() >= 2)
        {
            // Supprimer toutes les demandes faites, sauf celle qui est acceptée éventuellement
            foreach ($tabDemandesFaitesEtudiant as $demande)
            {
                if ($demande->getEstAcceptee() == false)
                {
                    $gestionnaireEntites->remove($demande);
                }
            }
            
            // Supprimer toutes les demandes reçues, sauf celle qui est acceptée éventuellement
            foreach ($tabDemandesRecuesEtudiant as $demande)
            {
                if ($demande->getEstAcceptee() == false)
                {
                    $gestionnaireEntites->remove($demande);
                }
            }
        }
        
        // Enregistrer les modifications
        $gestionnaireEntites->flush();
    }
    
    public function refuserDemandeAction($idDemande)
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupérer la demande à supprimer
            $repositoryDemandes = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:DemandeParrainage');
            $demande = $repositoryDemandes->find($idDemande);
            
            // La supprimer
            $gestionnaireEntites->remove($demande);
            
            // Enregistrer la suppression
            $gestionnaireEntites->flush();
            
            // Rediriger vers la page des demandes
            return $this->redirect($this->generateUrl('sitebde_parrainage_demandes'));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    
    /* ******************************************************************************************************************
       ******************************************     Partie Recherche     **********************************************
       ****************************************************************************************************************** */
    
    
    public function redirectionVersEtudiantAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer la chaîne contenant le prénom et le nom, en théorie
            $prenomNom = $_POST['prenomNom'];
            
            // Séparer le prénom du nom dans un tableau
            $tabPrenomNom = explode(' ', $prenomNom);
    
            // Si on a un prénom et un nom, analyser le résultat
            if (count($tabPrenomNom) == 2)
            {
                // Récupérer le prénom et le nom
                $prenom = $tabPrenomNom[0];
                $nom = $tabPrenomNom[1];
                
                // Récupérer le gestionnaire d'entités
                $gestionnaireEntites = $this->getDoctrine()->getManager();
                
                // Chercher un étudiant correspondant au prénom et au nom entrés
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                $etudiant = $repositoryEtudiants->findOneBy(array('nom' => $nom, 'prenom' => $prenom));
                
                // Si on a bien un résultat
                if ($etudiant != NULL)
                {
                    // Récupérer l'id de cet étudiant
                    $idEtudiant = $etudiant->getId();
                    
                    // Rediriger vers son profil
                    return $this->redirect($this->generateUrl('sitebde_parrainage_details_profil', array('idEtudiant' => $idEtudiant)));
                }
            }
            
            // Sinon, rediriger vers la page de la recherche sans résultats
            return $this->redirect($this->generateUrl('sitebde_parrainage_recherche_sans_resultat'));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function rechercheSansResultatAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Afficher la page
            return $this->render('sitebdeParrainageBundle:Parrainage:rechercheSansResultat.html.twig', array('etudiantConnecte' => $etudiantConnecte));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function rechercheAction(Request $requeteUtilisateur)
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupérer le gestionnaire d'entités
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupérer tous les étudiants pour l'auto-complétion de la recherche par nom prénom
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $etudiants = $repositoryEtudiants->findAll();
            
            // Récupérer tous les étudiants de l'autre année
            if ($etudiantConnecte['numAnnee'] == 1)
            {
                $autreAnnee = 2;
            }
            else
            {
                $autreAnnee = 1;
            }
            $etudiantsAutreAnnee = $repositoryEtudiants->getAllParAnnee($autreAnnee);
            
            // Constuire le formulaire
            $tabDonnees = array();
            $formulaire = $this->createFormBuilder($tabDonnees)
                ->add('matieresFortes', entityType::class, array('label' => 'Matières fortes cherchées',
                                                                 'class' => 'sitebdeParrainageBundle:Matiere',
                                                                 'choice_label' => 'libelle',
                                                                 'multiple' => true,
                                                                 'expanded' => true))
                ->add('matieresFaibles', entityType::class, array('label' => 'Matières faibles cherchées',
                                                                  'class' => 'sitebdeParrainageBundle:Matiere',
                                                                  'choice_label' => 'libelle',
                                                                  'multiple' => true,
                                                                  'expanded' => true))
                ->add('sports', entityType::class, array('label' => 'Sports cherchés',
                                                         'class' => 'sitebdeParrainageBundle:Sport',
                                                         'choice_label' => 'libelle',
                                                         'multiple' => true,
                                                         'expanded' => true))
                ->add('loisirs', entityType::class, array('label' => 'Loisirs cherchés',
                                                          'class' => 'sitebdeParrainageBundle:Loisir',
                                                          'choice_label' => 'libelle',
                                                          'multiple' => true,
                                                          'expanded' => true))
                ->getForm();
            $formulaire->handleRequest($requeteUtilisateur);
            
            // Si le formulaire a été soumis et qu'il est valide
            if($formulaire->isValid())
            {
                // Récupérer les données du formulaire
                $donnees = $formulaire->getData();
                
                $tabResultats = $this->rechercheCriteres($etudiantsAutreAnnee, $donnees["matieresFortes"], $donnees["matieresFaibles"], $donnees["loisirs"], $donnees["sports"]);
                
                $tabResultatsFinal = array();
                // Retirer l'étudiant connecté des recherches, s'il y est
                for ($i = 0; $i < sizeof($tabResultats); $i++)
                {
                    if ($tabResultats[$i][0]->getId() != $etudiantConnecte['id'])
                    {
                        $tabResultatsFinal[] = $tabResultats[$i];
                    }
                }
                
                // Si le tableau contenant les résultats de la recherche n'est pas vide
                if (sizeof($tabResultatsFinal))
                {
                    // Afficher la page des résultats
                    return $this->render('sitebdeParrainageBundle:Parrainage:resultatsRecherche.html.twig', array('tabResultats' => $tabResultatsFinal,
                                                                                                                  'etudiantConnecte' => $etudiantConnecte));
                }
                else
                {
                    // Sinon afficher la page de recherche sans résultats
                    return $this->render('sitebdeParrainageBundle:Parrainage:rechercheSansResultat.html.twig', array('etudiantConnecte' => $etudiantConnecte));
                }
            }
            
            $infosAffichage = array();
            
            // Récupérer les éléments nécessaires à l'organisation des listes de cases à cocher Matiere
            $repositoryMatieres = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Matiere');
            $matieres = $repositoryMatieres->findAll();
            $tabIdMatieres = array();
            foreach($matieres as $matiere)
            {
                $tabIdMatieres[] = $matiere->getId();
                $infosAffichage['matieres'][$matiere->getId()] = array('categorie' => $matiere->getCategorie());
            }
            $infosAffichage['idsMatieres'] = array('min' => min($tabIdMatieres), 'max' => max($tabIdMatieres));
            
            // Récupérer les éléments nécessaires à l'organisation de la liste de cases à cocher Loisirs
            $repositoryLoisirs = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Loisir');
            $loisirs = $repositoryLoisirs->findAll();
            $tabIdLoisirs = array();
            foreach($loisirs as $loisir)
            {
                $tabIdLoisirs[] = $loisir->getId();
                $infosAffichage['loisirs'][$loisir->getId()] = array('categorie' => $loisir->getCategorie());
            }
            $infosAffichage['idsLoisirs'] = array('min' => min($tabIdLoisirs), 'max' => max($tabIdLoisirs));
            
            // Récupérer les éléments nécessaires à l'organisation de la liste de cases à cocher Sports
            $repositorySports = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Sport');
            $sports = $repositorySports->findAll();
            $tabIdSports = array();
            foreach($sports as $sport)
            {
                $tabIdSports[] = $sport->getId();
                $infosAffichage['sports'][$sport->getId()] = array('categorie' => $sport->getCategorie());
            }
            $infosAffichage['idsSports'] = array('min' => min($tabIdSports), 'max' => max($tabIdSports));

            
            $infosAffichageJSON = json_encode($infosAffichage);
        
            // Afficher le formulaire
            return $this->render('sitebdeParrainageBundle:Parrainage:formulaireRecherche.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                            'etudiants' => $etudiants,
                                                                                                            'etudiantConnecte' => $etudiantConnecte,
                                                                                                            'infosAffichageJSON' => $infosAffichageJSON));
        }
        else
        {
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function rechercheCorrespondance(&$nbCorrespondances, $attributRecherche, $etudiant, $cible)
    {
        $etudiantMatiereFortes = $etudiant->getEtudiantMatiereFortes();
        $etudiantMatiereFaibles = $etudiant->getEtudiantMatiereFaibles();
        $etudiantLoisirs = $etudiant->getLoisirsAssocies();
        $etudiantSports = $etudiant->getSportsAssocies();
        
        switch($attributRecherche)
        {
            case "matieresFortes":
                for ($i = 0; $i < sizeof($etudiantMatiereFortes); $i++)
                {
                    for ($j = 0; $j < sizeof($cible); $j++)
                    {
                        if ($etudiantMatiereFortes[$i] == $cible[$j])
                        {
                            $nbCorrespondances++;
                        }
                    }
                }
                break;
                
            case "matieresFaibles":
                for ($i = 0; $i < sizeof($etudiantMatiereFaibles); $i++)
                {
                    for ($j = 0; $j < sizeof($cible); $j++)
                    {
                        if ($etudiantMatiereFaibles[$i] == $cible[$j])
                        {
                            $nbCorrespondances++;
                        }
                    }
                }
                break;
                
            case "loisirs":
                for ($i = 0; $i < sizeof($etudiantLoisirs); $i++)
                {
                    for ($j = 0; $j < sizeof($cible); $j++)
                    {
                        if ($etudiantLoisirs[$i] == $cible[$j])
                        {
                            $nbCorrespondances++;
                        }
                    }
                }
                break;
            
            case "sports":
                for ($i = 0; $i < sizeof($etudiant->getSportsAssocies()); $i++)
                {
                    for ($j = 0; $j < sizeof($cible); $j++)
                    {
                        if ($etudiant->getSportsAssocies()[$i] == $cible[$j])
                        {
                            $nbCorrespondances++;
                        }
                    }
                }
                break;
        }
    }
    
    public function echanger(&$val1, &$val2)
    {
        $temp = $val1;
        $val1 = $val2;
        $val2 = $temp;
    }
    
    public function propositionsEtudiants($etudiantsAutreAnnee, $etudiantConnecte, $nombreVoulu)
    {
        $tabPropositions = null;
        $tabResultats = $this->rechercheCriteres($etudiantsAutreAnnee, $etudiantConnecte->getEtudiantMatiereFortes(), $etudiantConnecte->getEtudiantMatiereFaibles(),
        $etudiantConnecte->getLoisirsAssocies(), $etudiantConnecte->getSportsAssocies());
        
        if (sizeof($tabResultats) >= $nombreVoulu && $nombreVoulu > 0)
        {
            for ($i = 0; $i == $nombreVoulu; $i++)
            {
                $tabPropositions[] = $tabResultats[$i];
            }
        }
        if(sizeof($tabResultats) < $nombreVoulu)
        {
            foreach ($tabResultats as $resultat)
            {
                $tabPropositions[] = $resultat;
            }
        }
        return $tabPropositions;
    }
    
    // Retourne un tableau Résultat trié, qui pour [$i][0] a des étudiants et [$i][1] a des nombre de correspondances
    public function rechercheCriteres($etudiants, $criteresMatieresFortes, $criteresMatieresFaibles, $criteresLoisirs, $criteresSports, $garderLeReste = false)
    {
        $tabEtudiants = [];
        $tabNbCorr = [];
            
            
        foreach ($etudiants as $etudiant) {
            $nbCorrespondances = 0;
            
            $this->rechercheCorrespondance($nbCorrespondances, "matieresFortes", $etudiant, $criteresMatieresFortes);
            $this->rechercheCorrespondance($nbCorrespondances, "matieresFaibles", $etudiant, $criteresMatieresFaibles);
            $this->rechercheCorrespondance($nbCorrespondances, "loisirs", $etudiant,  $criteresLoisirs);
            $this->rechercheCorrespondance($nbCorrespondances, "sports", $etudiant,  $criteresSports);
                
            if ($nbCorrespondances > 0 || $garderLeReste)
            {
                $tabEtudiants[] = $etudiant;
                $tabNbCorr[] = $nbCorrespondances;
            }
        }
            
        for ($i = sizeof($tabNbCorr) - 1; $i > 0; $i--)
        {
            $tableauTrié = true;
            for ($j = 0; $j < $i; $j++)
            {
                if ($tabNbCorr[$j + 1] < $tabNbCorr[$j])
                {
                    $this->echanger($tabNbCorr[$j + 1], $tabNbCorr[$j]);
                    $this->echanger($tabEtudiants[$j + 1], $tabEtudiants[$j]);
                    $tableauTrié = false;
                }
            }
            if ($tableauTrié)
                break;
        }
            
        $tabNbCorr = array_reverse($tabNbCorr);
        $tabEtudiants = array_reverse($tabEtudiants);
        
        $tabResultats = [];
        
        for ($i = 0 ; $i < sizeof($tabEtudiants) ; $i++)
        {
            $tabResultats[$i][0] = $tabEtudiants[$i];
            $tabResultats[$i][1] = $tabNbCorr[$i];
        }
        
        return $tabResultats;
    }
}
