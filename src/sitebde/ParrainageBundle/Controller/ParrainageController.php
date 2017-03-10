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

use sitebde\ParrainageBundle\Form\EtudiantType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ParrainageController extends Controller
{
    public function accueilAction()
    {
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
        
        $etudiantConnecte = $repositoryEtudiants->findOneByNom('Lanusse');
        
        if ($etudiantConnecte->getNumAnnee() == 1)
        {
            $autreAnnee = 2;
        }
        else
        {
            $autreAnnee = 1;
        }
        
        $etudiantsAutreAnnee = $repositoryEtudiants->findByNumAnnee($autreAnnee);
        
        $tabEtudiants = $this->propositionsEtudiants($etudiantsAutreAnnee, $etudiantConnecte, 3);
        
        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:accueil.html.twig', array('etudiantsProposes' => $tabEtudiants, 'etudiants' => $etudiants));
    }
    
    public function listePremieresAnneesAction()
    {
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer tous les étudiants de première année, triés par ordre alphabétique de nom
        $tabEtudiantsPremieresAnnees = $repositoryEtudiants->findByNumAnnee("1", array("nom" => "ASC"));
        
        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:listePremieresAnnees.html.twig', array('etudiantsPremieresAnnees' => $tabEtudiantsPremieresAnnees, 'etudiants' => $etudiants));
    }
    
    public function listeDeuxiemesAnneesAction()
    {
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer tous les étudiants de deuxième année, triés par ordre alphabétique de nom
        $tabEtudiantsDeuxiemesAnnees = $repositoryEtudiants->findByNumAnnee("2", array("nom" => "ASC"));
        
        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:listeDeuxiemesAnnees.html.twig', array('etudiantsDeuxiemesAnnees' => $tabEtudiantsDeuxiemesAnnees, 'etudiants' => $etudiants));
    }
    
    public function detailsProfilAction($idEtudiant)
    {
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer l'étudiant dont l'id a été passé en paramètre (requête perso pour trier les activités et matières)
        $etudiant = $repositoryEtudiants->getEtudiantLoisirsEtSports($idEtudiant);
        
        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:detailsProfil.html.twig', array('etudiant' => $etudiant, 'etudiants' => $etudiants));
    }
    
    public function profilAction()
    {
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
        
        // Récupérer l'étudiant connecté -- Problème : récupérer l'étudiant connecté et pas Quentin
        $quentin = $repositoryEtudiants->findOneByNom('Lanusse');
        $etudiant = $repositoryEtudiants->getEtudiantLoisirsEtSports($quentin->getId());
        
        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:profil.html.twig', array('etudiant' => $etudiant, 'etudiants' => $etudiants));
    }
    
    public function redirectionVersEtudiantAction()
    {
        $redirection = "non déterminé";
        $nomComplet = $_POST['nomComplet'];
        $tabNomComplet = explode(" ", $nomComplet);

        
            
        if (count($tabNomComplet) == 2)
        {
            $prenom = $tabNomComplet[0];
            $nom = $tabNomComplet[1];
    
            $gestionnaireEntites = $this->getDoctrine()->getManager();
            $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
            
            $etudiant = $repositoryEtudiants->findOneBy(array(
                "nom" => $nom,
                "prenom" => $prenom));
            
            if ($etudiant != NULL) {
                $idEtudiant = $etudiant->getId();
                return $this->redirect($this->generateUrl('sitebde_parrainage_details_profil', array('idEtudiant' => $idEtudiant)));
            }
        }
        return $this->redirect($this->generateUrl('sitebde_parrainage_recherche_sans_resultat'));
    }
    
    public function rechercheSansResultatAction()
    {
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');

        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:rechercheSansResultat.html.twig', array('etudiants' => $etudiants));
    }
    
    public function rechercheCorrespondance(&$nbCorrespondances, $attributRecherche, /*\sitebde\ParrainageBundle\Entity\Etudiant */$etudiant, $cible)
    {
        $logger = $this->get('logger');
        
        switch($attributRecherche)
        {
            case "matieresFortes":
                for ($i = 0; $i < sizeof($etudiant->getEtudiantMatiereFortes()); $i++)
                {
                    for ($j = 0; $j < sizeof($cible); $j++)
                    {
                        if ($etudiant->getEtudiantMatiereFortes()[$i] == $cible[$j])
                        {
                            $nbCorrespondances++;
                        }
                    }
                }
                break;
                
            case "matieresFaibles":
                for ($i = 0; $i < sizeof($etudiant->getEtudiantMatiereFaibles()); $i++)
                {
                    for ($j = 0; $j < sizeof($cible); $j++)
                    {
                        if ($etudiant->getEtudiantMatiereFaibles()[$i] == $cible[$j])
                        {
                            $nbCorrespondances++;
                        }
                    }
                }
                break;
                
            case "loisirs":
                for ($i = 0; $i < sizeof($etudiant->getLoisirsAssocies()); $i++)
                {
                    for ($j = 0; $j < sizeof($cible); $j++)
                    {
                        if ($etudiant->getLoisirsAssocies()[$i] == $cible[$j])
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
        
        $tabResultats = $this->rechercheCriteres($etudiantsAutreAnnee, $etudiantConnecte->getEtudiantMatiereFortes(), $etudiantConnecte->getEtudiantMatiereFaibles(),
        $etudiantConnecte->getLoisirsAssocies(), $etudiantConnecte->getSportsAssocies());
        
        if (sizeof($tabResultats) >= $nombreVoulu && $nombreVoulu > 0)
        {
            for ($i = 0; $i = $nombreVoulu; $i++)
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
    public function rechercheCriteres($etudiants, $criteresMatieresFortes, $criteresMatieresFaibles, $criteresLoisirs, $criteresSports)
    {
        $tabEtudiants = [];
        $tabNbCorr = [];
            
        foreach ($etudiants as $etudiant) {
            $nbCorrespondances = 0;
            
            $this->rechercheCorrespondance($nbCorrespondances, "matieresFortes", $etudiant, $criteresMatieresFortes);
            $this->rechercheCorrespondance($nbCorrespondances, "matieresFaibles", $etudiant, $criteresMatieresFaibles);
            $this->rechercheCorrespondance($nbCorrespondances, "loisirs", $etudiant,  $criteresLoisirs);
            $this->rechercheCorrespondance($nbCorrespondances, "sports", $etudiant,  $criteresSports);
                
            if ($nbCorrespondances > 0)
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
    

    
    public function rechercheAction(Request $requeteUtilisateur)
    {
        $tabResultats = 0;
    
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
    
        $etudiants = $repositoryEtudiants->findAll();
        
        $tabDonnees = array();
        $titreFormulaire = 'Recherche par critères';
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
        
        if($formulaire->isValid())
        {
            $donnees = $formulaire->getData();
            
            $tabResultats = $this->rechercheCriteres($etudiants, $donnees["matieresFortes"], $donnees["matieresFaibles"], $donnees["loisirs"], $donnees["sports"]);
            
            return $this->render('sitebdeParrainageBundle:Parrainage:resultatsRecherche.html.twig', array('tabResultats' => $tabResultats,
                                                                                                          'etudiants' => $etudiants));
        }
        
        return $this->render('sitebdeParrainageBundle:Parrainage:formulaireRechercheCriteres.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                              'etudiants' => $etudiants,
                                                                                              'titreFormulaire' => $titreFormulaire));
    }
    
    public function profilEditionAction(Request $requeteUtilisateur)
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        
        $etudiant = $repositoryEtudiants->findOneByNom('Lanusse');
        $photoInitiale = $etudiant->getPhoto();
        
        $etudiant->setPhoto(new File($this->getParameter('photos_etudiants_dossier').$photoInitiale));
        
        $formulaire = $this->createForm(new EtudiantType, $etudiant);
            
        $formulaire->handleRequest($requeteUtilisateur);
        
        if ($formulaire->isValid())
        {
            $gestionnaireEntite->persist($etudiant);
            $gestionnaireEntite->flush();
            
            $photoFinale = $etudiant->getPhoto();
            
            if ($photoFinale != $photoInitiale)
            {
                $fileSystem = new Filesystem();
                $fileSystem->remove($this->getParameter('photos_etudiants_dossier').$photoInitiale);
            }
            
            return $this->redirect($this->generateUrl('sitebde_parrainage_profil'));
        }
        
        $etudiants = $repositoryEtudiants->findAll();
        $titreFormulaire = 'Editer mon profil';
        
        return $this->render('sitebdeParrainageBundle:Parrainage:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                              'etudiants' => $etudiants,
                                                                                              'titreFormulaire' => $titreFormulaire));
    }
    
    public function demandesAction()
    {
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
        $etudiant = $repositoryEtudiants->findOneByNom('Caillet');
        
        $etudiantDemandes = $repositoryEtudiants->getDemandesParrainage($etudiant->getId());
       
        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:demandes.html.twig', array('etudiantDemandes' => $etudiantDemandes,
                                                                                            'etudiants' => $etudiants));
    }
    
    public function demandeParrainageAction($idEtudiant)
    {
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
        $etudiant = $repositoryEtudiants->findOneByNom('Lanusse');
        $autreEtudiant = $repositoryEtudiants->find($idEtudiant);
        
        $demande = new DemandeParrainage($etudiant, $autreEtudiant, false);
        
        $gestionnaireEntites->persist($demande);
        $gestionnaireEntites->flush();
        
        /* Supprimer un etudiantLoisir -- Problème : vérifier qu'il l'a 
        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
        $etudiant = $repositoryEtudiants->findOneByNom('Lanusse');
        $repositoryLoisirs = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Loisir');
        $loisir = $repositoryLoisirs->findOneByLibelle('Animes');
        $repositoryEtudiantLoisirs = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:EtudiantLoisir');
        $etudiantloisir = $repositoryEtudiantLoisirs->findOneBy(array('etudiant' => $etudiant->getId(), 'loisir' => $loisir->getId()));
        
        $gestionnaireEntites->remove($etudiantloisir);
        $gestionnaireEntites->flush(); */
        
        /* Ajouter un etudiantSport -- Problème : vérifier qu'il l'a pas déjà
        $repositoryEtudiants = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Etudiant');
        $etudiant = $repositoryEtudiants->findOneByNom('Lanusse');
        $repositorySports = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:Sport');
        $sport = $repositorySports->findOneByLibelle('Handball');
        $etudiantsport = new EtudiantSport($etudiant, $sport);
        
        $gestionnaireEntites->persist($etudiantsport);
        $gestionnaireEntites->flush(); */
        
        return $this->redirect($this->generateUrl('sitebde_parrainage_demandes'));
    }
    
    public function accepterDemandeAction($idDemande)
    {
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        $repositoryDemandes = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:DemandeParrainage');
        $demandeAcceptee = $repositoryDemandes->find($idDemande);
        
        $demandeAcceptee->setEstAcceptee(true);
        $gestionnaireEntites->persist($demandeAcceptee);
        
        $etudiantDemandeur = $demandeAcceptee->getEtudiantDemandeur();
        $tabDemandesFaitesParDemandeur = $etudiantDemandeur->getDemandesFaites();
        $tabDemandesRecuesParDemandeur = $etudiantDemandeur->getDemandesRecues();
        
        if ($etudiantDemandeur->getNumAnnee() == 1)
        {
            foreach ($tabDemandesFaitesParDemandeur as $demande)
            {
                if ($demande->getEstAcceptee() == false)
                {
                    $gestionnaireEntites->remove($demande);
                }
            }
            
            foreach ($tabDemandesRecuesParDemandeur as $demande)
            {
                if ($demande->getEstAcceptee() == false)
                {
                    $gestionnaireEntites->remove($demande);
                }
            }
        }
        else
        {
            $nombreFilleuls = 0;
            
            foreach ($tabDemandesFaitesParDemandeur as $demande)
            {
                if ($demande->getEstAcceptee() == true)
                {
                    $nombreFilleuls++;
                }
            }
            
            foreach ($tabDemandesRecuesParDemandeur as $demande)
            {
                if ($demande->getEstAcceptee() == true)
                {
                    $nombreFilleuls++;
                }
            }
            
            if ($nombreFilleuls >= 2)
            {
                foreach ($tabDemandesFaitesParDemandeur as $demande)
                {
                    if ($demande->getEstAcceptee() == false)
                    {
                        $gestionnaireEntites->remove($demande);
                    }
                }
                
                foreach ($tabDemandesRecuesParDemandeur as $demande)
                {
                    if ($demande->getEstAcceptee() == false)
                    {
                        $gestionnaireEntites->remove($demande);
                    }
                }
            }
        }
        
        $etudiantDemande = $demandeAcceptee->getEtudiantDemande();
        $tabDemandesFaitesParDemande = $etudiantDemande->getDemandesFaites();
        $tabDemandesRecuesParDemande = $etudiantDemande->getDemandesRecues();
        
        if ($etudiantDemande->getNumAnnee() == 1)
        {
            foreach ($tabDemandesFaitesParDemande as $demande)
            {
                if ($demande->getEstAcceptee() == false)
                {
                    $gestionnaireEntites->remove($demande);
                }
            }
            
            foreach ($tabDemandesRecuesParDemande as $demande)
            {
                if ($demande->getEstAcceptee() == false)
                {
                    $gestionnaireEntites->remove($demande);
                }
            }
        }
        else
        {
            $nombreFilleuls = 0;
            
            foreach ($tabDemandesFaitesParDemande as $demande)
            {
                if ($demande->getEstAcceptee() == true)
                {
                    $nombreFilleuls++;
                }
            }
            
            foreach ($tabDemandesRecuesParDemande as $demande)
            {
                if ($demande->getEstAcceptee() == true)
                {
                    $nombreFilleuls++;
                }
            }
            
            if ($nombreFilleuls >= 2)
            {
                foreach ($tabDemandesFaitesParDemande as $demande)
                {
                    if ($demande->getEstAcceptee() == false)
                    {
                        $gestionnaireEntites->remove($demande);
                    }
                }
                
                foreach ($tabDemandesRecuesParDemande as $demande)
                {
                    if ($demande->getEstAcceptee() == false)
                    {
                        $gestionnaireEntites->remove($demande);
                    }
                }
            }
        }
        
        $gestionnaireEntites->flush();
        
        return $this->redirect($this->generateUrl('sitebde_parrainage_demandes'));
    }
    
    public function refuserDemandeAction($idDemande)
    {
        $gestionnaireEntites = $this->getDoctrine()->getManager();
        
        $repositoryDemandes = $gestionnaireEntites->getRepository('sitebdeParrainageBundle:DemandeParrainage');
        $demande = $repositoryDemandes->find($idDemande);
        
        $gestionnaireEntites->remove($demande);
        $gestionnaireEntites->flush();
       
        return $this->redirect($this->generateUrl('sitebde_parrainage_demandes'));
    }
}
