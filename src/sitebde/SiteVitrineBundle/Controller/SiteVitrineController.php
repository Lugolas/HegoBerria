<?php

namespace sitebde\SiteVitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteVitrineController extends Controller
{
    public function accueilAction()
    {
        // Récupérer les 2-3 derniers évènements et actualites
        $tabActualites = [];
        $tabEvenements = [];
        
        // Récupérer toutes les infos
        $tabInfos = [];
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:accueil.html.twig', array('actualites' => $tabActualites,
                                                                                             'evenements' => $tabEvenements,
                                                                                             'informations' => $tabInfos));
    }
    
    public function listeEvenementsAction()
    {
        // Récupérer tous les évènements
        $tabEvenements = [];
        
        // Récupérer toutes les infos
        $tabInfos = [];
        
        $typeArticle = "evenements";
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:listeArticles.html.twig', array('articles' => $tabEvenements,
                                                                                                   'typeArticle' => $typeArticle,
                                                                                                   'informations' => $tabInfos));
    }
    
    public function listeActualitesAction()
    {
        // Récupérer toutes les actualités
        $tabActualites = [];
        
        // Récupérer toutes les infos
        $tabInfos = [];
        
        $typeArticle = "actualites";
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:listeArticles.html.twig', array('articles' => $tabActualites,
                                                                                                   'typeArticle' => $typeArticle,
                                                                                                   'informations' => $tabInfos));
    }
    
    public function detailsEvenementAction($idEvent)
    {
        // Récupérer l'évènement
        $evenement = null;
        
        // Récupérer toutes les infos
        $tabInfos = [];
        
        $typeArticle = "evenement";
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:details.html.twig', array('article' => $evenement,
                                                                                             'typeArticle' => $typeArticle,
                                                                                             'informations' => $tabInfos));
    }
    
    public function detailsActualiteAction($idActu)
    {
        // Récupérer l'actualité
        $actualite = null;
        
        // Récupérer toutes les infos
        $tabInfos = [];
        
        $typeArticle = "actualite";
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:details.html.twig', array('article' => $actualite,
                                                                                             'typeArticle' => $typeArticle,
                                                                                             'informations' => $tabInfos));
    }
    
    public function informationAction($idInfo)
    {
        // Récupérer l'information
        $information = null;
        
        // Récupérer toutes les infos
        $tabInfos = [];
        
        $typeArticle = "information";
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:details.html.twig', array('article' => $information,
                                                                                             'typeArticle' => $typeArticle,
                                                                                             'informations' => $tabInfos));
    }
    
    public function connexionAction()
    {
        // Récupérer toutes les infos
        $tabInfos = [];
        
        return $this->render('sitebdeSiteVitrineBundle:SiteVitrine:connexion.html.twig', array('informations' => $tabInfos));
    }
}
