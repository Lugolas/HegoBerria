<?php

namespace sitebde\SiteVitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use sitebde\SiteVitrineBundle\Entity\Actualite;
use sitebde\SiteVitrineBundle\Entity\Evenement;
use sitebde\SiteVitrineBundle\Entity\Information;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\HttpFoundation\Request;

use sitebde\SiteVitrineBundle\Form\ActualiteType;
use sitebde\SiteVitrineBundle\Form\EvenementType;
use sitebde\SiteVitrineBundle\Form\InformationType;

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
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:accueil.html.twig', array('actualites' => $tabActualites,
                                                                                             'evenements' => $tabEvenements,
                                                                                             'informations' => $tabInfos));
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
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:listeActualites.html.twig', array('actualites' => $tabActualites,
                                                                                                     'informations' => $tabInfos));
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
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:details.html.twig', array('article' => $actualite,
                                                                                             'typeArticle' => $typeArticle,
                                                                                             'informations' => $tabInfos));
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
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:listeEvenements.html.twig', array('evenements' => $tabEvenements,
                                                                                                     'informations' => $tabInfos));
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
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:details.html.twig', array('article' => $evenement,
                                                                                             'typeArticle' => $typeArticle,
                                                                                             'informations' => $tabInfos));
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
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:listeInformations.html.twig', array('typeArticle' => $typeArticle,
                                                                                                       'informations' => $tabInfos));
    }
    
    public function connexionAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer toutes les infos pour le menu
        $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
        $tabInfos = $repositoryInformations->getInformationsTriees();
        
        // Afficher la page
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:connexion.html.twig', array('informations' => $tabInfos));
    }
    
    /* ******************************************************************************************************************
       ***********************************************     Partie BDE     ***********************************************
       ****************************************************************************************************************** */
    
    public function ajouterActualiteAction(Request $requeteUtilisateur)
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
        $typeArticle = 'actualite';
        $typeGestion = 'ajout';
        
        // Afficher le formulaire
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                'titreFormulaire' => $titreFormulaire,
                                                                                                'typeArticle' => $typeArticle,
                                                                                                'typeGestion' => $typeGestion,
                                                                                                'informations' => $tabInfos));
    }
    
    public function ajouterEvenementAction(Request $requeteUtilisateur)
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
        $typeArticle = 'evenement';
        $typeGestion = 'ajout';
        
        // Afficher le formulaire
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                'titreFormulaire' => $titreFormulaire,
                                                                                                'typeArticle' => $typeArticle,
                                                                                                'typeGestion' => $typeGestion,
                                                                                                'informations' => $tabInfos));
    }
    
    public function ajouterInformationAction(Request $requeteUtilisateur)
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
        $typeArticle = 'information';
        $typeGestion = 'ajout';
        
        // Afficher le formulaire
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                'titreFormulaire' => $titreFormulaire,
                                                                                                'typeArticle' => $typeArticle,
                                                                                                'typeGestion' => $typeGestion,
                                                                                                'informations' => $tabInfos));
    }
    
    public function modifierActualiteAction($idActu, Request $requeteUtilisateur)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'actualité à modifier
        $repositoryActualites = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Actualite');
        $actualite = $repositoryActualites->find($idActu);
        
        // Mettre à jour son icône pour qu'elle contienne le fichier et non le nom du fichier
        $iconeInitial = $actualite->getIcone();
        $actualite->setIcone(new File($this->getParameter('icones_articles_dossier').$iconeInitial));
        
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
        $typeArticle = 'actualite';
        $typeGestion = 'modification';
        
        // Afficher le formulaire
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                'titreFormulaire' => $titreFormulaire,
                                                                                                'typeArticle' => $typeArticle,
                                                                                                'typeGestion' => $typeGestion,
                                                                                                'informations' => $tabInfos));
    }
    
    
    public function modifierEvenementAction($idEvent, Request $requeteUtilisateur)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer l'événement à modifier
        $repositoryEvenements = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Evenement');
        $evenement = $repositoryEvenements->find($idEvent);
        
        // Mettre à jour son icône pour qu'elle contienne le fichier et non le nom du fichier
        $iconeInitial = $evenement->getIcone();
        $evenement->setIcone(new File($this->getParameter('icones_articles_dossier').$iconeInitial));
        
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
        $typeArticle = 'evenement';
        $typeGestion = 'modification';
        
        // Afficher le formulaire
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                'titreFormulaire' => $titreFormulaire,
                                                                                                'typeArticle' => $typeArticle,
                                                                                                'typeGestion' => $typeGestion,
                                                                                                'informations' => $tabInfos));
    }
    
    public function modifierInformationAction($idInfo, Request $requeteUtilisateur)
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
        $typeArticle = 'information';
        $typeGestion = 'modification';
        
        // Afficher le formulaire
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                'titreFormulaire' => $titreFormulaire,
                                                                                                'typeArticle' => $typeArticle,
                                                                                                'typeGestion' => $typeGestion,
                                                                                                'informations' => $tabInfos));
    }
    
    public function supprimerActualiteAction($idActu)
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
    
    public function supprimerEvenementAction($idEvent)
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
    
    public function supprimerInformationAction($idInfo)
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
}
