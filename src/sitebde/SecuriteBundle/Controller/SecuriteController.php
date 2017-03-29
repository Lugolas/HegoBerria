<?php

namespace sitebde\SecuriteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecuriteController extends Controller
{
    public function connexionAction()
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
        
        // Récupérer l'étudiant connecté
        $etudiantConnecte = $error = null;
        extract($_SESSION);
        session_destroy();
        
        return $this->render('sitebdeSecuriteBundle:Securite:connexion.html.twig', array('last_username' => $session->get(SecurityContext::LAST_USERNAME),
                                                                                      'error' => $error,
                                                                                      'informations' => $tabInfos,
                                                                                      'etudiantConnecte' => $etudiantConnecte,
                                                                                      'error' => $error));
    }
    
    public function verifConnexionPersoAction()
    {
        extract($_POST);
        
        $ldap_con = ldap_connect("mendibel.univ-pau.fr");
        
        if ($ldap_con)
        {
            echo "connexion ok<br>";
            
            try
            {
                if (ldap_bind($ldap_con,"uid=". $username .",ou=people,dc=univ-pau,dc=fr", $password) == -1)
                {
                    echo "bind ok";
                    
                    $base_dn = 'ou=people,dc=univ-pau,dc=fr';
                    
                    $critere = "uid=$username";
                    
                    
                    $ldapSearch = ldap_search($ldap_con, $base_dn, $critere);
                    $info = ldap_get_entries($ldap_con, $ldapSearch);
                    
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $repositoryEtudiant = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
                    
                    $personne =  explode(" ", $info[0]['cn'][0]);
                    
                    $filter = "objectClass=*";
                    
                    $etudiant = $repositoryEtudiant->findOneBy(array('nom' => $personne[0], 'prenom' => $personne[1]));
                    
                    if($etudiant)
                    {
                        session_destroy();
                        if (! session_id())
                        {
                            session_start();

                            $_SESSION['etudiantConnecte']['nom'] = $etudiant->getNom();
                            $_SESSION['etudiantConnecte']['prenom'] = $etudiant->getPrenom();
                            $_SESSION['etudiantConnecte']['id'] = $etudiant->getId();
                            $_SESSION['etudiantConnecte']['estBDE'] = $etudiant->getEstBDE();
                            $_SESSION['etudiantConnecte']['estAdmin'] = $etudiant->getEstAdmin();
                            $_SESSION['etudiantConnecte']['numAnnee'] = $etudiant->getNumAnnee();
                        }
                    }
                    return $this->redirect($this->generateUrl("sitebde_siteVitrine_accueil"));
                }
            }
            catch(\Exception $e)
            {
                $error = ldap_error($ldap_con);
                $errno = ldap_errno($ldap_con);
                $err2str = ldap_err2str($errno);
                
                session_destroy();
                if (! session_id())
                {
                    session_start();

                    $_SESSION['error']['error'] = $error;
                    $_SESSION['error']['errno'] = $errno;
                    $_SESSION['error']['err2str'] = $err2str;
                }
                return $this->redirect($this->generateUrl("connexion"));
            }
        }
            
        return $this->redirect($this->generateUrl("sitebde_siteVitrine_accueil"));
    }
    
    public function deconnexionPersoAction()
    {
        session_destroy();
        
        return $this->redirect($this->generateUrl("sitebde_siteVitrine_accueil"));
    }
}
