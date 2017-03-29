<?php

namespace sitebde\SiteVitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use sitebde\SiteVitrineBundle\Entity\Actualite;
use sitebde\SiteVitrineBundle\Entity\Evenement;
use sitebde\SiteVitrineBundle\Entity\Information;
use sitebde\ParrainageBundle\Entity\Etudiant;
use sitebde\ParrainageBundle\Entity\DemandeParrainage;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\HttpFoundation\Request;

use sitebde\SiteVitrineBundle\Form\ActualiteType;
use sitebde\SiteVitrineBundle\Form\EvenementType;
use sitebde\SiteVitrineBundle\Form\InformationType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class SiteVitrineController extends Controller
{
    
    /* ******************************************************************************************************************
       *****************************************     Partie Visiteurs     ***********************************************
       ****************************************************************************************************************** */
    
    
    public function accueilAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer les 3 dernières actualités
        $repositoryActualites = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Actualite');
        $tabActualites = $repositoryActualites->getTroisDernieresActualites();
        
        // Récupérer les 3 derniers évènements
        $repositoryEvenement = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Evenement');
        
        $tabEvenements = $repositoryEvenement->getTroisEvenementsAVenir();
        
        // Récupérer toutes les infos pour le menu
        $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
        $tabInfos = $repositoryInformations->getInformationsTriees();
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:accueil.html.twig', array('actualites' => $tabActualites,
                                                                                             'evenements' => $tabEvenements,
                                                                                             'informations' => $tabInfos,
                                                                                             'etudiantConnecte' => $etudiantConnecte));
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
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:mentionsLegales.html.twig',
               array('informations' => $tabInfos,
                     'etudiantConnecte' => $etudiantConnecte));
    }
    
    public function listeActualitesAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer toutes les actualités pour la page
        $repositoryActualites = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Actualite');
        $tabActualites = $repositoryActualites->getActualitesTriees();
        
        // Récupérer toutes les infos pour le menu
        $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
        $tabInfos = $repositoryInformations->getInformationsTriees();
        
        // Type d'article nécessaire pour la vue
        $typeArticle = 'actualite';
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:listeActualites.html.twig', array('actualites' => $tabActualites,
                                                                                                     'informations' => $tabInfos,
                                                                                                     'etudiantConnecte' => $etudiantConnecte));
    }
    
    public function detailsActualiteAction($idActu)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'actualité
        $repositoryActualites = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Actualite');
        $actualite = $repositoryActualites->find($idActu);
        
        // Récupérer toutes les infos pour le menu
        $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
        $tabInfos = $repositoryInformations->getInformationsTriees();
        
        // Type d'article nécessaire pour la vue
        $typeArticle = 'actualite';
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:details.html.twig', array('article' => $actualite,
                                                                                             'typeArticle' => $typeArticle,
                                                                                             'informations' => $tabInfos,
                                                                                             'etudiantConnecte' => $etudiantConnecte));
    }
    
    public function listeEvenementsAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer tous les évènements pour la page
        $repositoryEvenement = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Evenement');
        $tabEvenements = $repositoryEvenement->getEvenementsTries();
        
        // Récupérer toutes les infos pour le menu
        $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
        $tabInfos = $repositoryInformations->getInformationsTriees();
        
        // Type d'article nécessaire pour la vue
        $typeArticle = 'evenement';
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:listeEvenements.html.twig', array('evenements' => $tabEvenements,
                                                                                                     'informations' => $tabInfos,
                                                                                                     'etudiantConnecte' => $etudiantConnecte));
    }
    
    public function detailsEvenementAction($idEvent)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'évènement
        $repositoryEvenement = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Evenement');
        $evenement = $repositoryEvenement->find($idEvent);
        
        // Récupérer toutes les infos pour le menu
        $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
        $tabInfos = $repositoryInformations->getInformationsTriees();
        
        // Type d'article nécessaire pour la vue
        $typeArticle = 'evenement';
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:details.html.twig', array('article' => $evenement,
                                                                                             'typeArticle' => $typeArticle,
                                                                                             'informations' => $tabInfos,
                                                                                             'etudiantConnecte' => $etudiantConnecte));
    }
    
    public function informationAction($idInfo)
    {
        // Rediriger vers la route qui affiche la liste des informations, avec l'ancre de l'information qu'on veut afficher en particulier (ça se fait automatiquement)
        return $this->redirect($this->generateUrl('sitebde_siteVitrine_liste_informations').'#'.$idInfo);
    }
    
    public function listeInformationsAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer toutes les infos pour le menu et pour le contenu de la page
        $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
        $tabInfos = $repositoryInformations->getInformationsTriees();
        
        // Type d'article nécessaire pour la vue
        $typeArticle ='information';
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:listeInformations.html.twig', array('typeArticle' => $typeArticle,
                                                                                                       'informations' => $tabInfos,
                                                                                                       'etudiantConnecte' => $etudiantConnecte));
    }
    
    
    /* ******************************************************************************************************************
       ***********************************************     Partie BDE     ***********************************************
       ****************************************************************************************************************** */
    
    
    public function ajouterActualiteAction(Request $requeteUtilisateur)
    {
        // Récupérer le gestionnaire d'entité
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
             // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                $membresBDE = $repositoryEtudiants->findByEstBDE(1);
                $etudiantConnecteEntite = $repositoryEtudiants->findOneById($etudiantConnecte['id']);
                
                if(in_array($etudiantConnecteEntite, $membresBDE))
                {
                    // Récupérer le gestionnaire d'entités
                    $gestionnaireEntites = $this->getDoctrine()->getManager();
                    
                    // Créer un objet Actualite vide
                    $actualite = new Actualite();
                    
                    // Mettre ses dates d'actualisation et de publication à la date actuelle
                    $actualite->setDateActualisation(new \DateTime('now'));
                    $actualite->setDatePublication(new \DateTime('now'));
                    
                    // Construire le formulaire et le gérer
                    $formulaire = $this->createForm(ActualiteType::class, $actualite);
                    $formulaire->handleRequest($requeteUtilisateur);
                    
                    // Si le formulaire a été soumis et qu'il est valide
                    if ($formulaire->isValid())
                    {
                        // Enregistrer la nouvelle actualité
                        $gestionnaireEntites->persist($actualite);
                        $gestionnaireEntites->flush();
                        
                        // Rediriger vers la liste des actualités
                        return $this->redirect($this->generateUrl('sitebde_siteVitrine_liste_actualites'));
                    }
                    
                    // Récupérer toutes les infos
                    $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
                    $tabInfos = $repositoryInformations->getInformationsTriees();
                    
                    // Quelques variables nécessaires pour la vue
                    $titreFormulaire = 'Ajouter une actualité';
                    $texteBoutonFormulaire = 'Créer l\'actualité';
                    $typeArticle = 'actualite';
                    $typeGestion = 'ajout';
                    
                    // Récupérer l'étudiant connecté
                    $etudiantConnecte = null;
                    if (session_id())
                    {
                        extract($_SESSION);
                    }
                    
                    // Afficher le formulaire
                    return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                            'titreFormulaire' => $titreFormulaire,
                                                                                                            'boutonFormulaire' => $texteBoutonFormulaire,
                                                                                                            'typeArticle' => $typeArticle,
                                                                                                            'typeGestion' => $typeGestion,
                                                                                                            'informations' => $tabInfos,
                                                                                                            'etudiantConnecte' => $etudiantConnecte));
                }
            else
            {
                // Si l'étudiant connecté n'est pas membre du BDE, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
                    
    }
    
    public function modifierActualiteAction($idActu, Request $requeteUtilisateur)
    {
        // Récupérer le gestionnaire d'entité
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
             // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                $membresBDE = $repositoryEtudiants->findByEstBDE(1);
                $etudiantConnecteEntite = $repositoryEtudiants->findOneById($etudiantConnecte['id']);
                
                if(in_array($etudiantConnecteEntite, $membresBDE))
                {
                    // Récupérer le gestionnaire d'entités
                    $gestionnaireEntites = $this->getDoctrine()->getManager();
                    
                    // Récupérer l'actualité à modifier
                    $repositoryActualites = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Actualite');
                    $actualite = $repositoryActualites->find($idActu);
                    
                    // Mettre à jour son icône pour l'upload et la miniature
                    $iconeInitial = $actualite->getIcone();
                    $actualite->setImageFile(new File($this->getParameter('icones_articles_dossier').$iconeInitial));
                    
                    // Construire le formulaire et le gérer
                    $formulaire = $this->createForm(ActualiteType::class, $actualite);
                    $formulaire->handleRequest($requeteUtilisateur);
                    
                    // Si le formulaire a été soumis et qu'il est valide
                    if ($formulaire->isValid())
                    {
                        // Enregistrer les modifications
                        $gestionnaireEntites->persist($actualite);
                        $gestionnaireEntites->flush();
                        
                        // Si l'icône a été modifié, supprimer l'ancien
                        $iconeFinal = $actualite->getIcone();
                        if ($iconeFinal != $iconeInitial)
                        {
                            $fileSystem = new Filesystem();
                            $fileSystem->remove($this->getParameter('icones_articles_dossier').$iconeInitial);
                        }
                        
                        // Rediriger vers la liste des actualités
                        return $this->redirect($this->generateUrl('sitebde_siteVitrine_liste_actualites'));
                    }
                    
                    // Récupérer toutes les infos
                    $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
                    $tabInfos = $repositoryInformations->getInformationsTriees();
                    
                    // Quelques variables nécessaires pour la vue
                    $titreFormulaire = 'Modifier une actualité';
                    $texteBoutonFormulaire = 'Modifier l\'actualité';
                    $typeArticle = 'actualite';
                    $typeGestion = 'modification';
                    
                    // Récupérer l'étudiant connecté
                    $etudiantConnecte = null;
                    if (session_id())
                    {
                        extract($_SESSION);
                    }
                    
                    // Afficher le formulaire
                    return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                            'titreFormulaire' => $titreFormulaire,
                                                                                                            'boutonFormulaire' => $texteBoutonFormulaire,
                                                                                                            'typeArticle' => $typeArticle,
                                                                                                            'typeGestion' => $typeGestion,
                                                                                                            'informations' => $tabInfos,
                                                                                                            'etudiantConnecte' => $etudiantConnecte));
                }
            else
            {
                // Si l'étudiant connecté n'est pas membre du BDE, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
                    
    }
    
    public function supprimerActualiteAction($idActu)
    {
        // Récupérer le gestionnaire d'entité
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
             // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                $membresBDE = $repositoryEtudiants->findByEstBDE(1);
                $etudiantConnecteEntite = $repositoryEtudiants->findOneById($etudiantConnecte['id']);
                
                if(in_array($etudiantConnecteEntite, $membresBDE))
                {
                    // Récupérer le gestionnaire d'entités
                    $gestionnaireEntites = $this->getDoctrine()->getManager();
                    
                    // Récupérer l'actualité à supprimer
                    $repositoryActualites = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Actualite');
                    $actualite = $repositoryActualites->find($idActu);
                    
                    // La supprimer
                    $gestionnaireEntites->remove($actualite);
                    $gestionnaireEntites->flush();
                    
                    // Rediriger vers la liste des actualités
                    return $this->redirect($this->generateUrl('sitebde_siteVitrine_liste_actualites'));
                }
            else
            {
                // Si l'étudiant connecté n'est pas membre du BDE, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
                    
    }
    
    public function ajouterEvenementAction(Request $requeteUtilisateur)
    {
        // Récupérer le gestionnaire d'entité
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
             // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                $membresBDE = $repositoryEtudiants->findByEstBDE(1);
                $etudiantConnecteEntite = $repositoryEtudiants->findOneById($etudiantConnecte['id']);
                
                if(in_array($etudiantConnecteEntite, $membresBDE))
                {
                    // Récupérer le gestionnaire d'entités
                    $gestionnaireEntites = $this->getDoctrine()->getManager();
                    
                    // Créer un objet Evenement vide
                    $evenement = new Evenement();
                    
                    // Mettre ses dates d'actualisation, de publication et d'événement à la date actuelle
                    $evenement->setDateActualisation(new \DateTime('now'));
                    $evenement->setDatePublication(new \DateTime('now'));
                    $evenement->setDateEvenement(new \DateTime('now'));
                    
                    // Construire le formulaire et le gérer
                    $formulaire = $this->createForm(EvenementType::class, $evenement);
                    $formulaire->handleRequest($requeteUtilisateur);
                    
                    // Si le formulaire a été soumis et qu'il est valide
                    if ($formulaire->isValid())
                    {
                        // Enregistrer le nouvel événement
                        $gestionnaireEntites->persist($evenement);
                        $gestionnaireEntites->flush();
                        
                        // Rediriger vers la liste des événements
                        return $this->redirect($this->generateUrl('sitebde_siteVitrine_liste_evenements'));
                    }
                    
                    // Récupérer toutes les infos
                    $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
                    $tabInfos = $repositoryInformations->getInformationsTriees();
                    
                    // Quelques variables nécessaires pour la vue
                    $titreFormulaire = 'Ajouter un évenement';
                    $texteBoutonFormulaire = 'Créer l\'événement';
                    $typeArticle = 'evenement';
                    $typeGestion = 'ajout';
                    
                    // Récupérer l'étudiant connecté
                    $etudiantConnecte = null;
                    if (session_id())
                    {
                        extract($_SESSION);
                    }
                    
                    // Afficher le formulaire
                    return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                            'titreFormulaire' => $titreFormulaire,
                                                                                                            'boutonFormulaire' => $texteBoutonFormulaire,
                                                                                                            'typeArticle' => $typeArticle,
                                                                                                            'typeGestion' => $typeGestion,
                                                                                                            'informations' => $tabInfos,
                                                                                                            'etudiantConnecte' => $etudiantConnecte));
                }
            else
            {
                // Si l'étudiant connecté n'est pas membre du BDE, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
        
                    
    }
    
    public function modifierEvenementAction($idEvent, Request $requeteUtilisateur)
    {
        // Récupérer le gestionnaire d'entité
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
             // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                $membresBDE = $repositoryEtudiants->findByEstBDE(1);
                $etudiantConnecteEntite = $repositoryEtudiants->findOneById($etudiantConnecte['id']);
                
                if(in_array($etudiantConnecteEntite, $membresBDE))
                {
                    // Récupérer le gestionnaire d'entités
                    $gestionnaireEntites = $this->getDoctrine()->getManager();
                    
                    // Récupérer l'événement à modifier
                    $repositoryEvenements = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Evenement');
                    $evenement = $repositoryEvenements->find($idEvent);
                    
                    // Mettre à jour son icône pour l'upload et la miniature
                    $iconeInitial = $evenement->getIcone();
                    $evenement->setImageFile(new File($this->getParameter('icones_articles_dossier').$iconeInitial));
                    
                    // Construire le formulaire et le gérer
                    $formulaire = $this->createForm(EvenementType::class, $evenement);
                    $formulaire->handleRequest($requeteUtilisateur);
                    
                    // Si le formulaire a été soumis et qu'il est valide
                    if ($formulaire->isValid())
                    {
                        // Enregistrer les modifications
                        $gestionnaireEntites->persist($evenement);
                        $gestionnaireEntites->flush();
                        
                        // Si l'icône a été modifié, supprimer l'ancien
                        $iconeFinal = $evenement->getIcone();
                        if ($iconeFinal != $iconeInitial)
                        {
                            $fileSystem = new Filesystem();
                            $fileSystem->remove($this->getParameter('icones_articles_dossier').$iconeInitial);
                        }
                        
                        // Rediriger vers la liste des événements
                        return $this->redirect($this->generateUrl('sitebde_siteVitrine_liste_evenements'));
                    }
                    
                    // Récupérer toutes les infos
                    $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
                    $tabInfos = $repositoryInformations->getInformationsTriees();
                    
                    // Quelques variables nécessaires pour la vue
                    $titreFormulaire = 'Modifier un événement';
                    $texteBoutonFormulaire = 'Modifier l\'événement';
                    $typeArticle = 'evenement';
                    $typeGestion = 'modification';
                    
                    // Récupérer l'étudiant connecté
                    $etudiantConnecte = null;
                    if (session_id())
                    {
                        extract($_SESSION);
                    }
                    
                    // Afficher le formulaire
                    return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                            'titreFormulaire' => $titreFormulaire,
                                                                                                            'boutonFormulaire' => $texteBoutonFormulaire,
                                                                                                            'typeArticle' => $typeArticle,
                                                                                                            'typeGestion' => $typeGestion,
                                                                                                            'informations' => $tabInfos,
                                                                                                            'etudiantConnecte' => $etudiantConnecte));
                }
            else
            {
                // Si l'étudiant connecté n'est pas membre du BDE, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
                    
    }
    
    public function supprimerEvenementAction($idEvent)
    {
        // Récupérer le gestionnaire d'entité
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
             // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                $membresBDE = $repositoryEtudiants->findByEstBDE(1);
                $etudiantConnecteEntite = $repositoryEtudiants->findOneById($etudiantConnecte['id']);
                
                if(in_array($etudiantConnecteEntite, $membresBDE))
                {
                    // Récupérer le gestionnaire d'entités
                    $gestionnaireEntites = $this->getDoctrine()->getManager();
                    
                    // Récupérer l'évènement à supprimer
                    $repositoryEvenements = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Evenement');
                    $evenement = $repositoryEvenements->find($idEvent);
                    
                    // Le supprimer
                    $gestionnaireEntites->remove($evenement);
                    $gestionnaireEntites->flush();
                    
                    // Rediriger vers la liste des événements
                    return $this->redirect($this->generateUrl('sitebde_siteVitrine_liste_evenements'));
                }
            else
            {
                // Si l'étudiant connecté n'est pas membre du BDE, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
                    
    }
    
    public function ajouterInformationAction(Request $requeteUtilisateur)
    {
        // Récupérer le gestionnaire d'entité
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
             // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                $membresBDE = $repositoryEtudiants->findByEstBDE(1);
                $etudiantConnecteEntite = $repositoryEtudiants->findOneById($etudiantConnecte['id']);
                
                if(in_array($etudiantConnecteEntite, $membresBDE))
                {
                    // Récupérer le gestionnaire d'entités
                    $gestionnaireEntites = $this->getDoctrine()->getManager();
                    
                    // Créer un objet Information vide
                    $information = new Information();
                    
                    // Mettre ses dates d'actualisation et de publication à la date actuelle
                    $information->setDateActualisation(new \DateTime('now'));
                    $information->setDatePublication(new \DateTime('now'));
                    
                    // Construire le formulaire et le gérer
                    $formulaire = $this->createForm(InformationType::class, $information);
                    $formulaire->handleRequest($requeteUtilisateur);
                    
                    // Si le formulaire a été soumis et qu'il est valide
                    if ($formulaire->isValid())
                    {
                        // Enregistrer la nouvelle information
                        $gestionnaireEntites->persist($information);
                        $gestionnaireEntites->flush();
                        
                        // Rediriger vers la liste des informations
                        return $this->redirect($this->generateUrl('sitebde_siteVitrine_liste_informations').'#'.$information->getId());
                    }
                    
                    // Récupérer toutes les infos
                    $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
                    $tabInfos = $repositoryInformations->getInformationsTriees();
                    
                    // Quelques variables nécessaires pour la vue
                    $titreFormulaire = 'Ajouter une information';
                    $texteBoutonFormulaire = 'Créer l\'information';
                    $typeArticle = 'information';
                    $typeGestion = 'ajout';
                    
                    // Récupérer l'étudiant connecté
                    $etudiantConnecte = null;
                    if (session_id())
                    {
                        extract($_SESSION);
                    }
                    
                    // Afficher le formulaire
                    return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                            'titreFormulaire' => $titreFormulaire,
                                                                                                            'boutonFormulaire' => $texteBoutonFormulaire,
                                                                                                            'typeArticle' => $typeArticle,
                                                                                                            'typeGestion' => $typeGestion,
                                                                                                            'informations' => $tabInfos,
                                                                                                            'etudiantConnecte' => $etudiantConnecte));
                }
            else
            {
                // Si l'étudiant connecté n'est pas membre du BDE, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
        
                    
    }
    
    public function modifierInformationAction($idInfo, Request $requeteUtilisateur)
    {
        // Récupérer le gestionnaire d'entité
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
             // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                $membresBDE = $repositoryEtudiants->findByEstBDE(1);
                $etudiantConnecteEntite = $repositoryEtudiants->findOneById($etudiantConnecte['id']);
                
                if(in_array($etudiantConnecteEntite, $membresBDE))
                {
                    // Récupérer le gestionnaire d'entités
                    $gestionnaireEntites = $this->getDoctrine()->getManager();
                    
                    // Récupérer l'information à modifier
                    $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
                    $information = $repositoryInformations->find($idInfo);
                    
                    // Construire le formulaire et le gérer
                    $formulaire = $this->createForm(InformationType::class, $information);
                    $formulaire->handleRequest($requeteUtilisateur);
                    
                    // Si le formulaire a été soumis et qu'il est valide
                    if ($formulaire->isValid())
                    {
                        // Enregistrer les modifications
                        $gestionnaireEntites->persist($information);
                        $gestionnaireEntites->flush();
                        
                        // Rediriger vers la liste des informations
                        return $this->redirect($this->generateUrl('sitebde_siteVitrine_liste_informations').'#'.$information->getId());
                    }
                    
                    // Récupérer toutes les infos
                    $tabInfos = $repositoryInformations->getInformationsTriees();
                    
                    // Quelques variables nécessaires pour la vue
                    $titreFormulaire = 'Modifier une information';
                    $texteBoutonFormulaire = 'Modifier l\'information';
                    $typeArticle = 'information';
                    $typeGestion = 'modification';
                    
                    // Récupérer l'étudiant connecté
                    $etudiantConnecte = null;
                    if (session_id())
                    {
                        extract($_SESSION);
                    }
                    
                    // Afficher le formulaire
                    return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                            'titreFormulaire' => $titreFormulaire,
                                                                                                            'boutonFormulaire' => $texteBoutonFormulaire,
                                                                                                            'typeArticle' => $typeArticle,
                                                                                                            'typeGestion' => $typeGestion,
                                                                                                            'informations' => $tabInfos,
                                                                                                            'etudiantConnecte' => $etudiantConnecte));
                }
            else
            {
                // Si l'étudiant connecté n'est pas membre du BDE, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
                    
    }
    
    public function supprimerInformationAction($idInfo)
    {
        // Récupérer le gestionnaire d'entité
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
             // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                $membresBDE = $repositoryEtudiants->findByEstBDE(1);
                $etudiantConnecteEntite = $repositoryEtudiants->findOneById($etudiantConnecte['id']);
                
                if(in_array($etudiantConnecteEntite, $membresBDE))
                {
                    // Récupérer le gestionnaire d'entités
                    $gestionnaireEntites = $this->getDoctrine()->getManager();
                    
                    // Récupérer l'information à supprimer
                    $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
                    $information = $repositoryInformations->find($idInfo);
                    
                    // Le supprimer
                    $gestionnaireEntites->remove($information);
                    $gestionnaireEntites->flush();
                    
                    // Rediriger vers la liste des informations
                    return $this->redirect($this->generateUrl('sitebde_siteVitrine_liste_informations'));
                }
            else
            {
                // Si l'étudiant connecté n'est pas membre du BDE, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
                    
    }
    
    
    /* ******************************************************************************************************************
       **********************************************     Partie Admin     **********************************************
       ****************************************************************************************************************** */
    
    
    
    public function pageAdminAction(Request $requeteUtilisateur)
    {
        // Récupérer le gestionnaire d'entité
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
             // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                $admin = $repositoryEtudiants->findOneByEstAdmin(1);
                
                if($etudiantConnecte['id'] == $admin->getId())
                {
                    // Constuire le formulaire
                    $tabDonneesDuMessage = array(); 
                    $formulaire = $this->createFormBuilder($tabDonneesDuMessage)
                        ->add('dateActu', dateType::class, array('label' => 'Supprimer toutes les actualités antérieures au :', 'format' => 'dd/MM/yyyy', 'widget' => 'choice', 'data' => new \DateTime()))
                        ->add('dateEvent', dateType::class, array('label' => 'Supprimer tous les événements antérieurs au :', 
                            'format' => 'dd/MM/yyyy', 'widget' => 'choice', 'data' => new \DateTime()))
                        ->add('dateInfo', dateType::class, array('label' => 'Supprimer toutes les informations antérieures au :', 'format' => 'dd/MM/yyyy', 'widget' => 'choice', 'data' => new \DateTime()))
                        ->getForm();
                    $formulaire->handleRequest($requeteUtilisateur);
                    
                    // Si le formulaire a été soumis et qu'il est valide
                    if($formulaire->isValid())
                    {
                        // Récupérer les données du formulaire
                        $donnees = $formulaire->getData();
                        
                        if ($donnees['dateActu'])
                        
                        // Rediriger vers la page d'accueil
                        return $this->redirect($this->generateUrl('sitebde_siteVitrine_accueil'));
                    }
                    
                    // Récupérer le gestionnaire d'entités
                    $gestionnaireEntites = $this->getDoctrine()->getManager();
                    
                    // Récupérer toutes les infos
                    $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
                    $tabInfos = $repositoryInformations->getInformationsTriees();
                    
                    
                    // Afficher le formulaire
                    return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:pageAdmin.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                           'informations' => $tabInfos,
                                                                                                           'etudiantConnecte' => $etudiantConnecte));
            }
            else
            {
                // Si l'étudiant connecté n'est pas l'admin, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function actualiserEtudiantsBDAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $admin = $repositoryEtudiants->findOneByEstAdmin(1);
            
            if($etudiantConnecte['id'] == $admin->getId())
            {
                extract($_POST);
                
                $ldap_con = ldap_connect("mendibel.univ-pau.fr");
                
                if ($ldap_con)
                {
                    if (ldap_bind($ldap_con, "uid=" . $username . ",ou=people,dc=univ-pau,dc=fr", $password))
                    {
                        // Enregistrer l'image user.png afin de la remettre une fois tous les étudiants supprimés
                        $photoUser = new Filesystem();
                        $photoUser->copy($this->getParameter('photos_etudiants_dossier')."user.png", "user.png");
                        
                        $base_dn = 'ou=people,dc=univ-pau,dc=fr';
                        $criteresRecherche1ereAnnees = "supannetuinscription=*libEtape=DUT Informatique 1*";
                        $criteresRecherche2emeAnnees = "supannetuinscription=*libEtape=DUT Informatique 2*";
                        
                        
                        $ldapSearch1ereAnnees = ldap_search($ldap_con, $base_dn, $criteresRecherche1ereAnnees);
                        $ldapSearch2emeAnnees = ldap_search($ldap_con, $base_dn, $criteresRecherche2emeAnnees);
                        
                        $info1ereAnnee = ldap_get_entries($ldap_con, $ldapSearch1ereAnnees);
                        $info2emeAnnee = ldap_get_entries($ldap_con, $ldapSearch2emeAnnees);
                        
                        $gestionnaireEntites = $this->getDoctrine()->getManager();
                        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                        
                        $etudiants = $repositoryEtudiants->findAll();
                        
                        foreach($etudiants as $unEtudiant)
                        {
                            $liensASupprimer = $repositoryEtudiants->getEtudiantLoisirsEtSports($unEtudiant->getId());
                            foreach($liensASupprimer as $element)
                            {
                                $gestionnaireEntites->remove($element);
                            }
                            $gestionnaireEntites->remove($unEtudiant);
                        }
                        $gestionnaireEntites->flush();
                        
                        $taille = count($info2emeAnnee);
                        
                        for ($i = 0; $i < $taille - 2; $i++)
                        {
                            $nomComplet = explode(" ", $info2emeAnnee[$i]['cn'][0]);
                            $etudiant = new Etudiant();
                            $etudiant->setLogin($info2emeAnnee[$i]['uid'][0]);
                            $etudiant->setNom($nomComplet[0]);
                            $etudiant->setPrenom($nomComplet[1]);
                            $etudiant->setNumAnnee(2);
                            $etudiant->setPhoto("user.png");
                            if($username == $info2emeAnnee[$i]['uid'][0])
                            {
                                $etudiant->setEstBDE(true);
                                $etudiant->setEstAdmin(true);
                            }
                            else
                            {
                                $etudiant->setEstBDE(false);
                                $etudiant->setEstAdmin(false);
                            }
                            $etudiant->setNbDemandesValidees(0);
                            if ($info2emeAnnee[$i]['supanncivilite'][0] == "M.")
                            {
                                $etudiant->setSexe("M");
                            }
                            else
                            {
                                $etudiant->setSexe("F");
                            }
                            
                            $gestionnaireEntites->persist($etudiant);
                        }
                        $gestionnaireEntites->flush();
                        
                        $taille = count($info1ereAnnee);
                        
                        for ($i = 0; $i < $taille - 2; $i++)
                        {
                            $nomComplet = explode(" ", $info1ereAnnee[$i]['cn'][0]);
                            $etudiant = new Etudiant();
                            $etudiant->setLogin($info1ereAnnee[$i]['uid'][0]);
                            $etudiant->setNom($nomComplet[0]);
                            $etudiant->setPrenom($nomComplet[1]);
                            $etudiant->setNumAnnee(1);
                            $etudiant->setPhoto("user.png");
                            if($username == $info1ereAnnee[$i]['uid'][0])
                            {
                                $etudiant->setEstBDE(true);
                                $etudiant->setEstAdmin(true);
                            }
                            else
                            {
                                $etudiant->setEstBDE(false);
                                $etudiant->setEstAdmin(false);
                            }
                            $etudiant->setNbDemandesValidees(0);
                            if ($info1ereAnnee[$i]['supanncivilite'][0] == "M.")
                            {
                                $etudiant->setSexe("M");
                            }
                            else
                            {
                                $etudiant->setSexe("F");
                            }
                            
                            $gestionnaireEntites->persist($etudiant);
                        }
                        $gestionnaireEntites->flush();
                        
                        session_destroy();
                        
                        // Remettre l'image user.png en place
                        $photoUser->copy("user.png", $this->getParameter('photos_etudiants_dossier')."user.png");
                        $photoUser->remove("user.png");
                        
                        return $this->redirect($this->generateUrl("sitebde_siteVitrine_page_admin"));
                        
                    }
                }
            }
            else
            {
                // Si l'étudiant connecté n'est pas l'admin, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function gererDroitsEtudiantsAction(Request $requeteUtilisateur)
    {
        // Récupérer toutes les infos
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
        $tabInfos = $repositoryInformations->getInformationsTriees();
            
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $admin = $repositoryEtudiants->findOneByEstAdmin(1);
            
            if($etudiantConnecte['id'] == $admin->getId())
            {
                // Création du formulaire
                $titreFormulaire = 'Gestion des droits des étudiants';
                $tabDonneesDuMessage = array();
                $formulaire = $this->createFormBuilder($tabDonneesDuMessage)
                        ->add('definitionMembresBDE', entityType::class, array('label' => 'Définir les membres du BDE',
                                                           'class' => 'sitebdeParrainageBundle:Etudiant',
                                                           'choice_label' => 'login',
                                                           'multiple' => true,
                                                           'expanded' => true,
                                                           'required' => true))
                        ->add('definitionAdmin', entityType::class, array('label' => 'Définir l\'admin du site',
                                                           'class' => 'sitebdeParrainageBundle:Etudiant',
                                                           'choice_label' => 'login',
                                                           'multiple' => false,
                                                           'expanded' => true,
                                                           'required' => true))
                        ->getForm();
                $formulaire->handleRequest($requeteUtilisateur);
                
                if ($formulaire->isValid())
                    {
                        // Récupérer les anciens membres du BDE et admin afin de leur enlever leurs droits
                        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                        $ancienBDE = $repositoryEtudiants->getMembresBDE();
                        
                        // Retirer les droits aux anciens membres
                        foreach($ancienBDE as $membre)
                        {
                            $membre->setEstBDE(0);
                            $membre->setEstAdmin(0);
                            $gestionnaireEntites->persist($membre);
                        }
                        
                        // Récupérer les données du formulaire 
                        $donnees = $formulaire->getData();
                        
                        // Récupérer l'administrateur et les nouveaux membres du BDE
                        $admin = $donnees['definitionAdmin'];
                        $membresBDE = $donnees['definitionMembresBDE'];
                        
                        // Donner les droits d'administrateur à l'admin
                        $admin->setEstAdmin(1);
                        
                        // Donner les droits de membre du BDE aux membres du BDE
                        foreach($membresBDE as $unMembre)
                        {
                            $unMembre->setEstBDE(1);
                            $gestionnaireEntites->persist($unMembre);
                        }
                        
                        // Enregistrer toutes les modifications en BD
                        $gestionnaireEntites->flush();
                        
                        // Déconnecter l'admin actuel afin qu'il n'ait plus les droit d'aministrateur si l'administrateur a changé
                        session_destroy();
                        
                        // Rediriger vers la page admin
                        return $this->redirect($this->generateUrl('sitebde_siteVitrine_page_admin'));
                    }
                
                
                // Afficher le formulaire
                return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaireDroitsEtudiants.html.twig', array('formulaire' => $formulaire->createView(),
                                                                   'informations' => $tabInfos,
                                                                   'titreFormulaire' => $titreFormulaire,
                                                                   'etudiantConnecte' => $etudiantConnecte));
            }
            else
            {
                // Si l'étudiant connecté n'est pas l'admin, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
        
        
    }
    
    public function associationsAutomatiqueAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $admin = $repositoryEtudiants->findOneByEstAdmin(1);
            
            if($etudiantConnecte['id'] == $admin->getId())
            {
                // Récupérer le gestionnaire d'entités
                $gestionnaireEntites = $this->getDoctrine()->getManager();
                
                // Récupérer tous les étudiants pour faire toutes les associations
                $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
                
                // Récupérer toutes les demandes non validées
                $repositoryDemandesNonValidees = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:DemandeParrainage');
                $demandesNonValidees = $repositoryDemandesNonValidees->getDemandesNonValidees();
                
                // Supprimer les demandes non validées
                foreach($demandesNonValidees as $uneDemande)
                {
                    $gestionnaireEntites->remove($uneDemande);
                }
                $gestionnaireEntites->flush();
                
                // Récupérer les étudiants de première année non parrainnés
                $etudiants1A = $repositoryEtudiants->findBy(array('numAnnee' => 1, 'nbDemandesValidees' => 0));
                
                // Récupérer les étudiants de deuxième année pouvant encore parrainer
                $deuxiemesAnnees = $repositoryEtudiants->findByNumAnnee(2);
                
                // Booléen permettant de définir si tous les deuxième années ont déjà au moins un filleul, si c'est le cas, certains deuxième années récupèreront un deuxième filleul
                $tousLes2emeAnneesParrainentUnePersonne = false;
                
                foreach($etudiants1A as $unPremiereAnnee)
                {
                    foreach($deuxiemesAnnees as $unDeuxiemeAnnee)
                    {
                        if($unDeuxiemeAnnee->getNbDemandesValidees() == 0)
                        {
                            $tousLes2emeAnneesParrainentUnePersonne = false;
                            break;
                        }
                        $tousLes2emeAnneesParrainentUnePersonne = true;
                    }
                    
                    if($tousLes2emeAnneesParrainentUnePersonne)
                    {
                        foreach($deuxiemesAnnees as $unDeuxiemeAnnee)
                        {
                            if($unDeuxiemeAnnee->getNbDemandesValidees() == 1)
                            {
                                 // Créer une nouvelle demande de parrainage entre les deux étudiants, acceptée
                                $demande = new DemandeParrainage($unPremiereAnnee, $unDeuxiemeAnnee, true);
                                
                                $unPremiereAnnee->setNbDemandesValidees($unPremiereAnnee->getNbDemandesValidees() + 1);
                                $unDeuxiemeAnnee->setNbDemandesValidees($unDeuxiemeAnnee->getNbDemandesValidees() + 1);
                                
                                // Enregistrer la nouvelle demande
                                $gestionnaireEntites->persist($demande);
                                $gestionnaireEntites->flush();
                                break;
                            }
                        }
                    }
                    else
                    {
                        foreach($deuxiemesAnnees as $unDeuxiemeAnnee)
                        {
                            if($unDeuxiemeAnnee->getNbDemandesValidees() == 0)
                            {
                                 // Créer une nouvelle demande de parrainage entre les deux étudiants, acceptée
                                $demande = new DemandeParrainage($unPremiereAnnee, $unDeuxiemeAnnee, true);
                                
                                $unPremiereAnnee->setNbDemandesValidees($unPremiereAnnee->getNbDemandesValidees() + 1);
                                $unDeuxiemeAnnee->setNbDemandesValidees($unDeuxiemeAnnee->getNbDemandesValidees() + 1);
                                
                                // Enregistrer la nouvelle demande
                                $gestionnaireEntites->persist($demande);
                                $gestionnaireEntites->flush();
                                break;
                            }
                        }
                    }
                }
                return $this->redirect($this->generateUrl('sitebde_siteVitrine_page_admin'));
            }
            else
            {
                // Si l'étudiant connecté n'est pas l'admin, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
    }
    
    public function supprimerEvenementsParDateAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            //Récupérer le gestionnaire d'entite
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $admin = $repositoryEtudiants->findOneByEstAdmin(1);
            
            if($etudiantConnecte['id'] == $admin->getId())
            {
                $repositoryEvenements = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Evenement');
                
                // Récupérer la date limite
                extract($_POST);
                $dateSuppression = $form['dateEvent'];
                $jour = $dateSuppression["day"];
                $mois = $dateSuppression['month'];
                $annee = $dateSuppression['year'];
                // Récupérer la date limite sous le format d'un entier
                $dateLimite = strtotime($jour . "-" . $mois . "-" . $annee);
                
                // Récupérer tous les événements et supprimer ceux demandés
                $events = $repositoryEvenements->findAll();
                foreach($events as $evt)
                {
                    // Récupérer la date de publication sous le format d'un entier
                    $datePublication = $evt->getDatePublication()->getTimestamp() ;
                    
                    // Si la date de publication est inférieure à la date limite on supprime l'événement
                    if ($datePublication < $dateLimite)
                    {
                       $gestionnaireEntites->remove($evt);
                    }
                }
                $gestionnaireEntites->flush();
                
                return $this->redirect($this->generateUrl('sitebde_siteVitrine_page_admin'));
            }
            else
            {
                // Si l'étudiant connecté n'est pas l'admin, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
        
    }
    
    public function supprimerActualitesParDateAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            //Récupérer le gestionnaire d'entite
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $admin = $repositoryEtudiants->findOneByEstAdmin(1);
            
            if($etudiantConnecte['id'] == $admin->getId())
            {
                $repositoryActualites = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Actualite');
                
                // Récupérer la date limite
                extract($_POST);
                $dateSuppression = $form['dateActu'];
                $jour = $dateSuppression["day"];
                $mois = $dateSuppression['month'];
                $annee = $dateSuppression['year'];
                // Récupérer la date limite sous le format d'un entier
                $dateLimite = strtotime($jour . "-" . $mois . "-" . $annee);
                
                // Récupérer tous les événements et supprimer ceux demandés
                $actus = $repositoryActualites->findAll();
                foreach($actus as $actu)
                {
                    // Récupérer la date de publication sous le format d'un entier
                    $datePublication = $actu->getDatePublication()->getTimestamp() ;
                    
                    // Si la date de publication est inférieure à la date limite on supprime l'événement
                    if ($datePublication < $dateLimite)
                    {
                       $gestionnaireEntites->remove($actu);
                    }
                }
                $gestionnaireEntites->flush();
                
                return $this->redirect($this->generateUrl('sitebde_siteVitrine_page_admin'));
            }
            else
            {
                // Si l'étudiant connecté n'est pas l'admin, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
        
    }
    
    public function supprimerInformationsParDateAction()
    {
        // Récupérer l'étudiant connecté
        $etudiantConnecte = null;
        if (session_id())
        {
            extract($_SESSION);
        }
        
        if ($etudiantConnecte)
        {
            //Récupérer le gestionnaire d'entite
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            
            // Récupération de l'admin du site afin de vérifier que l'étudiant connecté est bien administrateur
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            $admin = $repositoryEtudiants->findOneByEstAdmin(1);
            
            if($etudiantConnecte['id'] == $admin->getId())
            {
                
                $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
                
                // Récupérer la date limite
                extract($_POST);
                $dateSuppression = $form['dateInfo'];
                $jour = $dateSuppression["day"];
                $mois = $dateSuppression['month'];
                $annee = $dateSuppression['year'];
                // Récupérer la date limite sous le format d'un entier
                $dateLimite = strtotime($jour . "-" . $mois . "-" . $annee);
                
                // Récupérer tous les événements et supprimer ceux demandés
                $infos = $repositoryInformations->findAll();
                foreach($infos as $info)
                {
                    // Récupérer la date de publication sous le format d'un entier
                    $datePublication = $info->getDatePublication()->getTimestamp() ;
                    
                    // Si la date de publication est inférieure à la date limite on supprime l'événement
                    if ($datePublication < $dateLimite)
                    {
                       $gestionnaireEntites->remove($info);
                    }
                }
                $gestionnaireEntites->flush();
                
                return $this->redirect($this->generateUrl('sitebde_siteVitrine_page_admin'));
            }
            else
            {
                // Si l'étudiant connecté n'est pas l'admin, on le déconnecte puis on le redirige vers la page de connexion
                session_destroy();
                return $this->redirect($this->generateUrl('connexion'));
            }
        }
        else 
        {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirect($this->generateUrl("connexion"));
        }
        
    }
}
