<?php

namespace sitebde\SiteVitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        $tabEvenements = $repositoryEvenement->getTroisDerniersEvenements();
        
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
        
        $typeArticle = "evenements";
        
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
        
        $typeArticle = "actualites";
        
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
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:details.html.twig', array('article' => $information,
                                                                                             'typeArticle' => $typeArticle,
                                                                                             'informations' => $tabInfos));
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
}
