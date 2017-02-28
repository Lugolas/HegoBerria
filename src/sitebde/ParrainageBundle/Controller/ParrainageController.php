<?php

namespace sitebde\ParrainageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use sitebde\ParrainageBundle\Entity\EtudiantMatiereFaible;
use sitebde\ParrainageBundle\Entity\EtudiantMatiereForte;
use sitebde\ParrainageBundle\Entity\EtudiantSport;
use sitebde\ParrainageBundle\Entity\EtudiantLoisir;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


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
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        
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

        
            
        if (count($tabNomComplet) == 2)
        {
            $prenom = $tabNomComplet[0];
            $nom = $tabNomComplet[1];
    
            $gestionnaireEntite = $this->getDoctrine()->getManager();
            $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
            
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
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');

        $etudiants = $repositoryEtudiants->findAll();
        
        return $this->render('sitebdeParrainageBundle:Parrainage:rechercheSansResultat.html.twig', array('etudiants' => $etudiants));
    }
    
    public function rechercheAction()
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');

        $etudiants = $repositoryEtudiants->findAll();
        
        foreach ($etudiants as $etudiant) {
            rechercheCorrespondance($nbCorrespondances, "matieresFortes", $etudiant, $matieresFortes);
            rechercheCorrespondance($nbCorrespondances, "matieresFaibles", $etudiant, $matieresFaibles);
            rechercheCorrespondance($nbCorrespondances, "loisirs", $etudiant, $loisirs);
            rechercheCorrespondance($nbCorrespondances, "sports", $etudiant, $sports);
            
            $tabResultats["$etudiant->getId()"][0] = $etudiant;
            $tabResultats[][1] = $etudiant;
        }
        
        return $this->render('sitebdeParrainageBundle:Parrainage:resultatsRecherche.html.twig', array('etudiants' => $etudiants));
    }
    
    private function rechercheCorrespondance(&$nbCorrespondances, $attributRecherche, $etudiant, $cible) //Ca serait bien de typer le paramètre en tant que Etudiant, mais je sais pas coment on fait
    {
        switch($attributRecherche)
        {
            case "matieresFortes":
                for ($i = 0; $i < sizeof($etudiant->getEtudiantMatiereFortes()); $i++)
                {
                    for ($j = 0; $j < sizeof($cible); $j++)
                    {
                        if ($etudiant->getEtudiantMatiereFortes()[$i]->matiere == $cible[$j])
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
                        if ($etudiant->getEtudiantMatiereFaibles[$i]->matiere == $cible[$j])
                        {
                            $nbCorrespondances++;
                        }
                    }
                }
                break;
                
            case "loisirs":
                for ($i = 0; $i < sizeof($etudiant->getEtudiantLoisirs); $i++)
                {
                    for ($j = 0; $j < sizeof($cible); $j++)
                    {
                        if ($etudiant->etudiantLoisirs[$i]->loisir == $cible[$j])
                        {
                            $nbCorrespondances++;
                        }
                    }
                }
                break;
            
            case "sports":
                for ($i = 0; $i < sizeof($etudiant->etudiantSports); $i++)
                {
                    for ($j = 0; $j < sizeof($cible); $j++)
                    {
                        if ($etudiant->etudiantSports[$i]->sport == $cible[$j])
                        {
                            $nbCorrespondances++;
                        }
                    }
                }
                break;
        }
    }
    
    public function profilEditionAction(Request $requeteUtilisateur)
    {
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $repositoryEtudiants = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Etudiant');
        $repositoryMatieres = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Matiere');
        $repositorySports = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Sport');
        $repositoryLoisirs = $gestionnaireEntite->getRepository('sitebdeParrainageBundle:Loisir');
        
        $etudiants = $repositoryEtudiants->findAll();
        $titreFormulaire = 'Modifier mon profil';
        
        $etudiantConnecte = $repositoryEtudiants->findOneByNom('Lanusse');
        $listeMatieres = $repositoryMatieres->findAll();
        $listeLoisirs = $repositoryLoisirs->findAll();
        $listeSports = $repositorySports->findAll();
        
        $titreFormulaire = 'Editer mon profil';
        
        $donneesFormulaire = array();
        
        $formulaire = $this->createFormBuilder($donneesFormulaire)
            ->add('description', TextareaType::class)
            ->add('matieresFortes', entityType::class, array('label' => 'Mes matières fortes',
                                                    'class' => 'sitebdeParrainageBundle:Matiere',
                                                    'choice_label' => 'libelle',
                                                    'multiple' => true,
                                                    'expanded' => true))
            ->add('matieresFaibles', entityType::class, array('label' => 'Mes matières faibles',
                                                    'class' => 'sitebdeParrainageBundle:Matiere',
                                                    'choice_label' => 'libelle',
                                                    'multiple' => true,
                                                    'expanded' => true))
            ->add('loisirs', entityType::class, array('label' => 'Mes loisirs',
                                                    'class' => 'sitebdeParrainageBundle:Loisir',
                                                    'choice_label' => 'libelle',
                                                    'multiple' => true,
                                                    'expanded' => true))
            ->add('sports', entityType::class, array('label' => 'Mes sports',
                                                    'class' => 'sitebdeParrainageBundle:Sport',
                                                    'choice_label' => 'libelle',
                                                    'multiple' => true,
                                                    'expanded' => true))
            ->getForm()
        ;
            
        $formulaire->handleRequest($requeteUtilisateur);
        
        if ($formulaire->isValid())
        {
            $donneesFormulaire = $formulaire->getData();
            
            return $this->redirect(generateUrl('sitebde_parrainage_profil'));
        }
        
        
        return $this->render('sitebdeParrainageBundle:Parrainage:formulaire.html.twig', array('formulaire' => $formulaire->createView(),
                                                                                              'etudiants' => $etudiants,
                                                                                              'titreFormulaire' => $titreFormulaire));
    }
    
    
}
