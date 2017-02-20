<?php

namespace sitebde\SiteVitrineBundle\Controller;
use sitebde\SiteVitrineBundle\Entity\Actualite;
use sitebde\SiteVitrineBundle\Entity\Evenement;
use sitebde\SiteVitrineBundle\Entity\Information;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use sitebde\SiteVitrineBundle\Form\ActualiteType;
use sitebde\SiteVitrineBundle\Form\EvenementType;
use sitebde\SiteVitrineBundle\Form\InformationType;

class SiteVitrineController extends Controller
{
    public function accueilAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer les repositories des entités Actualité, Evènement et Information
        $repositoryActualites = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Actualite');
        $repositoryEvenement = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Evenement');
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer les 3 derniers évènements et actualites
        $tabActualites = $repositoryActualites->getTroisDernieresActualites();
        $tabEvenements = $repositoryEvenement->getTroisEvenementsAVenir();
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:accueil.html.twig', array('actualites' => $tabActualites,
                                                                                             'evenements' => $tabEvenements,
                                                                                             'informations' => $tabInfos));
    }
    
    public function listeEvenementsAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer les repositories des entités Evènement et Information
        $repositoryEvenement = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Evenement');
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer tous les évènements
        $tabEvenements = $repositoryEvenement->getEvenementsTries();
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        $typeArticle = "evenement";
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:listeArticles.html.twig', array('articles' => $tabEvenements,
                                                                                                   'typeArticle' => $typeArticle,
                                                                                                   'informations' => $tabInfos));
    }
    
    public function listeActualitesAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer les repositories des entités Actualité et Information
        $repositoryActualites = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Actualite');
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer toutes les actualités
        $tabActualites = $repositoryActualites->getActualitesTriees();
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        $typeArticle = "actualite";
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:listeArticles.html.twig', array('articles' => $tabActualites,
                                                                                                   'typeArticle' => $typeArticle,
                                                                                                   'informations' => $tabInfos));
    }
    
    public function detailsEvenementAction($idEvent)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer les repositories des entités Evènement et Information
        $repositoryEvenement = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Evenement');
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer l'évènement
        $evenement = $repositoryEvenement->find($idEvent);
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        $typeArticle = "evenement";
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:details.html.twig', array('article' => $evenement,
                                                                                             'typeArticle' => $typeArticle,
                                                                                             'informations' => $tabInfos));
    }
    
    public function detailsActualiteAction($idActu)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer les repositories des entités Actualité et Information
        $repositoryActualites = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Actualite');
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer l'actualité
        $actualite = $repositoryActualites->find($idActu);
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        $typeArticle = "actualite";
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:details.html.twig', array('article' => $actualite,
                                                                                             'typeArticle' => $typeArticle,
                                                                                             'informations' => $tabInfos));
    }
    
    public function informationAction($idInfo)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer le repository de l'entité Information
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer l'information
        $information = $repositoryInformation->find($idInfo);
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        $typeArticle = "information";
        
        return $this->redirect($this->generateUrl('sitebde_siteVitrine_listeInformations').'#'.$information->getId());
        
    }
    
    public function listeInformationsAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer le repository de l'entité Information
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        $typeArticle = "information";
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:listeArticles.html.twig', array('typeArticle' => $typeArticle,
                                                                                                   'informations' => $tabInfos,
                                                                                                   'articles' => $tabInfos));
    }
    
    public function connexionAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer le repository de l'entité Information
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:connexion.html.twig', array('informations' => $tabInfos));
    }
    
    public function ajouterActualiteAction(Request $requeteUtilisateur)
    {
        // On créé un objet Actualite vide
        $actualite = new Actualite();
        $actualite->setDateActualisation(new \DateTime('now'));
        $actualite->setDatePublication(new \DateTime('now'));
        
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // On construit le formulaire
        $formulaire = $this->createForm(ActualiteType::class, $actualite);
        $titreFormulaire = 'Ajouter une actualité';
        
        // Récupérer le repository de l'entité Information
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        $typeArticle = "actualite";
        
        // Enregistrer, après soumission, les données dans l'objet $actualite
        $formulaire->handleRequest($requeteUtilisateur);
        
        if ($formulaire->isValid())
        {
            $actualite = $formulaire->getData();
            
            // @var Symfony\Component\HttpFoundation\File\UploadedFile $icone -> icône uploadé
            $icone = $actualite->getIcone();

            // On génère un nom unique
            $nomIcone = md5(uniqid()).'.'.$icone->guessExtension();

            // On déplace le fichier
            $icone->move(
                $this->getParameter('icones_actualites_dossier'),
                $nomIcone
            );

            // On met à jour le champ pour contenir le nom du fichier et pas le fichier
            $actualite->setIcone($nomIcone);
            
            // Enregistrer l'actualité
            $gestionnaireEntite = $this->getDoctrine()->getManager();
            $gestionnaireEntite->persist($actualite);
            $gestionnaireEntite->flush();
            
            // Rediriger vers la liste des actualités
            return $this->redirect($this->generateUrl('sitebde_siteVitrine_listeActualites'));
        }
        
        // Afficher le formulaire
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                'typeArticle' => $typeArticle,
                                                                                                'informations' => $tabInfos,
                                                                                                'titreFormulaire' => $titreFormulaire));
    }
    
    public function ajouterEvenementAction(Request $requeteUtilisateur)
    {
        // On créé un objet Evenement vide
        $evenement = new Evenement();
        $evenement->setDateActualisation(new \DateTime('now'));
        $evenement->setDatePublication(new \DateTime('now'));
        $evenement->setDateEvenement(new \DateTime('now'));
        
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer le repository de l'entité Information
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        // On construit le formulaire
        $formulaire = $this->createForm(EvenementType::class, $evenement);
        $titreFormulaire = 'Ajouter un évenement'; 
            
        $typeArticle = 'evenement';
        
        // Enregistrer, après soumission, les données dans l'objet $evenement
        $formulaire->handleRequest($requeteUtilisateur);
        
        if ($formulaire->isValid())
        {
            // @var Symfony\Component\HttpFoundation\File\UploadedFile $icone -> icône uploadé
            $icone = $evenement->getIcone();

            // On génère un nom unique
            $nomIcone = md5(uniqid()).'.'.$icone->guessExtension();

            // On déplace le fichier
            $icone->move(
                $this->getParameter('icones_evenements_dossier'),
                $nomIcone
            );

            // On met à jour le champ pour contenir le nom du fichier et pas le fichier
            $evenement->setIcone($nomIcone);
            
            $gestionnaireEntite = $this->getDoctrine()->getManager();
            $gestionnaireEntite->persist($evenement);
            $gestionnaireEntite->flush();
            
            // On redirige vers la page qui liste les actualités
            return $this->redirect($this->generateUrl('sitebde_siteVitrine_listeEvenements'));
        }
        
        // A ce stade, le formulaire n'a pas été soumis, il faut donc l'afficher
       return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                'typeArticle' => $typeArticle,
                                                                                                'informations' => $tabInfos,
                                                                                                'titreFormulaire' => $titreFormulaire));
    }
    
    public function ajouterInformationAction(Request $requeteUtilisateur)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        
        // Récupérer le repository de l'entité Information
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        $typeArticle = 'information';
        
        
        $information = new Information();
        $information->setDateActualisation(new \DateTime('now'));
        $information->setDatePublication(new \DateTime('now'));
        
        $formulaire = $this->createForm(InformationType::class, $information);
        $titreFormulaire = 'Ajouter une information';
        
        // Enregistrer, après soumission, les données dans l'objet $information
        $formulaire->handleRequest($requeteUtilisateur);
        
        
        if ($formulaire->isValid())
        {
            $gestionnaireEntite = $this->getDoctrine()->getManager();
            $gestionnaireEntite->persist($information);
            $gestionnaireEntite->flush();
            
            return $this->redirect($this->generateUrl('sitebde_siteVitrine_listeInformations', array('id' => $information->getId())).'#'.$information->getId());
        }
        
        
       return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                'typeArticle' => $typeArticle,
                                                                                                'informations' => $tabInfos,
                                                                                                'titreFormulaire' => $titreFormulaire));
    }
    
    public function modifierActualiteAction($id, Request $requeteUtilisateur)
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryActualites = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Actualite');
        // Récupérer le repository de l'entité Information
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        $actualite = $repositoryActualites->find($id);
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        $typeArticle = "actualite";
        
        $formulaire = $this->createForm(ActualiteType::class, $actualite);
        $titreFormulaire = 'Modifier une actualité';
        
        // Enregistrer, après soumission, les données dans l'objet $actualite
        $formulaire->handleRequest($requeteUtilisateur);
        
        if ($formulaire->isValid())
        {
            // @var Symfony\Component\HttpFoundation\File\UploadedFile $icone -> icône uploadé
            $icone = $actualite->getIcone();

            // On génère un nom unique
            $nomIcone = md5(uniqid()).'.'.$icone->guessExtension();

            // On déplace le fichier
            $icone->move(
                $this->getParameter('icones_actualites_dossier'),
                $nomIcone
            );

            // On met à jour le champ pour contenir le nom du fichier et pas le fichier
            $actualite->setIcone($nomIcone);
            
            
            
            
            $gestionnaireEntite = $this->getDoctrine()->getManager();
            $gestionnaireEntite->persist($actualite);
            $gestionnaireEntite->flush();
            
            return $this->redirect($this->generateUrl('sitebde_siteVitrine_listeActualites'));
        }
        // Afficher le formulaire
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                'typeArticle' => $typeArticle,
                                                                                                'informations' => $tabInfos,
                                                                                                'titreFormulaire' => $titreFormulaire));
    }
    
    
    public function modifierEvenementAction($id, Request $requeteUtilisateur)
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEvenements = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Evenement');
        // Récupérer le repository de l'entité Information
        $repositoryInformation = $gestionnaireEntite->getRepository('sitebdeSiteVitrineBundle:Information');
        
        $evenement = $repositoryEvenements->find($id);
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformation->getInformationsTriees();
        
        $typeArticle = "evenement";
        
        $formulaire = $this->createForm(EvenementType::class, $evenement);
        $titreFormulaire = 'Modifier un évènement';
        
        // Enregistrer, après soumission, les données dans l'objet $actualite
        $formulaire->handleRequest($requeteUtilisateur);
        
        if ($formulaire->isValid())
        {
            // @var Symfony\Component\HttpFoundation\File\UploadedFile $icone -> icône uploadé
            $icone = $evenement->getIcone();

            // On génère un nom unique
            $nomIcone = md5(uniqid()).'.'.$icone->guessExtension();

            // On déplace le fichier
            $icone->move(
                $this->getParameter('icones_evenements_dossier'),
                $nomIcone
            );

            // On met à jour le champ pour contenir le nom du fichier et pas le fichier
            $evenement->setIcone($nomIcone);
            
            
            
            
            $gestionnaireEntite = $this->getDoctrine()->getManager();
            $gestionnaireEntite->persist($evenement);
            $gestionnaireEntite->flush();
            
            return $this->redirect($this->generateUrl('sitebde_siteVitrine_listeEvenements'));
        }
        // A ce stade, le formulaire n'a pas été soumis, il faut donc l'afficher
       return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                                'typeArticle' => $typeArticle,
                                                                                                'informations' => $tabInfos,
                                                                                                'titreFormulaire' => $titreFormulaire));
    }
}
