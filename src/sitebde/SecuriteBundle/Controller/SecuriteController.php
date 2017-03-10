<?php

namespace sitebde\SecuriteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecuriteController extends Controller
{
    public function loginAction()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        // Récupérer les repositories de l'entité Information
        $repositoryInformations = $gestionnaireEntites->getRepository('sitebdeSiteVitrineBundle:Information');
        
        // Récupérer toutes les infos
        $tabInfos = $repositoryInformations->getInformationsTriees();
        
        $request = $this->getRequest();
        $session = $request->getSession();
        
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) 
        {
            $error = $request->attributes
                             ->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        else
        {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('sitebdeSecuriteBundle:Securite:login.html.twig', array('last_username' => $session->get(SecurityContext::LAST_USERNAME),
                                                                                      'error' => $error,
                                                                                      'informations' => $tabInfos));
    }
}
