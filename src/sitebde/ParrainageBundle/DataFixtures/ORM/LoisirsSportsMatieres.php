<?php
// src/sitebde/ParrainageBundle/DataFixtures/ORM/insererEtud.php

namespace sitebde\ParrainageBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use sitebde\ParrainageBundle\Entity\Etudiant;
use sitebde\ParrainageBundle\Entity\Loisir;
use sitebde\ParrainageBundle\Entity\Matiere;
use sitebde\ParrainageBundle\Entity\EtudiantMatiereFaible;
use sitebde\ParrainageBundle\Entity\EtudiantMatiereForte;
use sitebde\ParrainageBundle\Entity\Sport;
use sitebde\ParrainageBundle\Entity\EtudiantSport;
use sitebde\ParrainageBundle\Entity\EtudiantLoisir;
use sitebde\ParrainageBundle\Entity\DemandeParrainage;
use sitebde\ParrainageBundle\Entity\Lien;

class Etudiants  implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        
        /* *****************/
        /* CREATION Sports */
        /* *****************/
        
        // En solo
        $artsMartiaux = new Sport();
        $artsMartiaux->setLibelle("Arts martiaux");
        $artsMartiaux->setCategorie("Solo");
        $manager->persist($artsMartiaux);
        
        $athletisme = new Sport();
        $athletisme->setLibelle("Athlétisme");
        $athletisme->setCategorie("Solo");
        $manager->persist($athletisme);
        
        $cyclisme = new Sport();
        $cyclisme->setLibelle("Cyclisme/VTT");
        $cyclisme->setCategorie("Solo");
        $manager->persist($cyclisme);
        
        $danse = new Sport();
        $danse->setLibelle("Danse");
        $danse->setCategorie("Solo");
        $manager->persist($danse);
        
        $equitation = new Sport();
        $equitation->setLibelle("Equitation");
        $equitation->setCategorie("Solo");
        $manager->persist($equitation);
        
        $escalade = new Sport();
        $escalade->setLibelle("Escalade");
        $escalade->setCategorie("Solo");
        $manager->persist($escalade);
        
        $golf = new Sport();
        $golf->setLibelle("Golf");
        $golf->setCategorie("Solo");
        $manager->persist($golf);
        
        $gym = new Sport();
        $gym->setLibelle("Gymnastique");
        $gym->setCategorie("Solo");
        $manager->persist($gym);
        
        $jogging = new Sport();
        $jogging->setLibelle("Jogging");
        $jogging->setCategorie("Solo");
        $manager->persist($jogging);
        
        $moto = new Sport();
        $moto->setLibelle("Moto");
        $moto->setCategorie("Solo");
        $manager->persist($moto);
        
        $muscu = new Sport();
        $muscu->setLibelle("Musculation");
        $muscu->setCategorie("Solo");
        $manager->persist($muscu);
        
        $natation = new Sport();
        $natation->setLibelle("Natation");
        $natation->setCategorie("Solo");
        $manager->persist($natation);
        
        $peche = new Sport();
        $peche->setLibelle("Pêche/Chasse");
        $peche->setCategorie("Solo");
        $manager->persist($peche);
        
        $rando = new Sport();
        $rando->setLibelle("Randonnée");
        $rando->setCategorie("Solo");
        $manager->persist($rando);
        
        $skate = new Sport();
        $skate->setLibelle("Skate/Rollers");
        $skate->setCategorie("Solo");
        $manager->persist($skate);
        
        $combat = new Sport();
        $combat->setLibelle("Sports de combat");
        $combat->setCategorie("Solo");
        $manager->persist($combat);
        
        $extreme = new Sport();
        $extreme->setLibelle("Sports extrêmes");
        $extreme->setCategorie("Solo");
        $manager->persist($extreme);
        
        $glisse = new Sport();
        $glisse->setLibelle("Sports de glisse");
        $glisse->setCategorie("Solo");
        $manager->persist($glisse);
        
        $surf = new Sport();
        $surf->setLibelle("Surf");
        $surf->setCategorie("Solo");
        $manager->persist($surf);
        
        $voile = new Sport();
        $voile->setLibelle("Voile");
        $voile->setCategorie("Solo");
        $manager->persist($voile);
        
        $yoga = new Sport();
        $yoga->setLibelle("Yoga/Méditation");
        $yoga->setCategorie("Solo");
        $manager->persist($yoga);
        
        // A plusieurs/Equipe
        $basket = new Sport();
        $basket->setLibelle("Basketball");
        $basket->setCategorie("A plusieurs/Equipe");
        $manager->persist($basket);
        
        $billard = new Sport();
        $billard->setLibelle("Billard");
        $billard->setCategorie("A plusieurs/Equipe");
        $manager->persist($billard);
        
        $bowling = new Sport();
        $bowling->setLibelle("Bowling");
        $bowling->setCategorie("A plusieurs/Equipe");
        $manager->persist($bowling);
        
        $foot = new Sport();
        $foot->setLibelle("Football");
        $foot->setCategorie("A plusieurs/Equipe");
        $manager->persist($foot);
        
        $footUSA = new Sport();
        $footUSA->setLibelle("Football américain");
        $footUSA->setCategorie("A plusieurs/Equipe");
        $manager->persist($footUSA);
        
        $handball = new Sport();
        $handball->setLibelle("Handball");
        $handball->setCategorie("A plusieurs/Equipe");
        $manager->persist($handball);
        
        $petanque = new Sport();
        $petanque->setLibelle("Pétanque");
        $petanque->setCategorie("A plusieurs/Equipe");
        $manager->persist($petanque);
        
        $rugby = new Sport();
        $rugby->setLibelle("Rugby");
        $rugby->setCategorie("A plusieurs/Equipe");
        $manager->persist($rugby);
        
        $tennis = new Sport();
        $tennis->setLibelle("Tennis");
        $tennis->setCategorie("A plusieurs/Equipe");
        $manager->persist($tennis);
        
        $tennisTable = new Sport();
        $tennisTable->setLibelle("Tennis de table");
        $tennisTable->setCategorie("A plusieurs/Equipe");
        $manager->persist($tennisTable);
        
        $volley = new Sport();
        $volley->setLibelle("Volley ball");
        $volley->setCategorie("A plusieurs/Equipe");
        $manager->persist($volley);
        
        $pasDeSport = new Sport();
        $pasDeSport->setLibelle("Aucun sport");
        $pasDeSport->setCategorie("Autre");
        $manager->persist($pasDeSport);
    
        
        /* ******************/
        /* CREATION Loisirs */
        /* ******************/
        
        // Audiovisuel
        $animes = new Loisir();
        $animes->setLibelle("Animes");
        $animes->setCategorie("Audiovisuel");
        $manager->persist($animes);
        
        $films = new Loisir();
        $films->setLibelle("Films");
        $films->setCategorie("Audiovisuel");
        $manager->persist($films);
        
        $musique = new Loisir();
        $musique->setLibelle("Musique");
        $musique->setCategorie("Audiovisuel");
        $manager->persist($musique);
        
        $theatre = new Loisir();
        $theatre->setLibelle("Pièces de théâtre");
        $theatre->setCategorie("Audiovisuel");
        $manager->persist($theatre);
        
        $series = new Loisir();
        $series->setLibelle("Séries");
        $series->setCategorie("Audiovisuel");
        $manager->persist($series);
        
        $tele = new Loisir();
        $tele->setLibelle("Télévision");
        $tele->setCategorie("Audiovisuel");
        $manager->persist($tele);
        
        // Lecture
        $bd = new Loisir();
        $bd->setLibelle("BDs");
        $bd->setCategorie("Lecture");
        $manager->persist($bd);
        
        $comics = new Loisir();
        $comics->setLibelle("Comics");
        $comics->setCategorie("Lecture");
        $manager->persist($comics);
        
        $mangas = new Loisir();
        $mangas->setLibelle("Mangas");
        $mangas->setCategorie("Lecture");
        $manager->persist($mangas);
        
        $romans = new Loisir();
        $romans->setLibelle("Romans");
        $romans->setCategorie("Lecture");
        $manager->persist($romans);
        
        // Jeux
        $cartes = new Loisir();
        $cartes->setLibelle("Jeux de cartes");
        $cartes->setCategorie("Jeux");
        $manager->persist($cartes);
        
        $figurines = new Loisir();
        $figurines->setLibelle("Jeux de figurines");
        $figurines->setCategorie("Jeux");
        $manager->persist($figurines);
        
        $JDR = new Loisir();
        $JDR->setLibelle("Jeux de rôles");
        $JDR->setCategorie("Jeux");
        $manager->persist($JDR);
        
        $societe = new Loisir();
        $societe->setLibelle("Jeux de société");
        $societe->setCategorie("Jeux");
        $manager->persist($societe);
        
        $jv = new Loisir();
        $jv->setLibelle("Jeux vidéo");
        $jv->setCategorie("Jeux");
        $manager->persist($jv);
        
        // Loisirs créatifs
        $animation = new Loisir();
        $animation->setLibelle("Animation");
        $animation->setCategorie("Loisirs créatifs");
        $manager->persist($animation);
        
        $chant = new Loisir();
        $chant->setLibelle("Chant");
        $chant->setCategorie("Loisirs créatifs");
        $manager->persist($chant);
        
        $comedie = new Loisir();
        $comedie->setLibelle("Comédie");
        $comedie->setCategorie("Loisirs créatifs");
        $manager->persist($comedie);
        
        $metrages = new Loisir();
        $metrages->setLibelle("Courts-moyens-longs métrages");
        $metrages->setCategorie("Loisirs créatifs");
        $manager->persist($metrages);
        
        $dessin = new Loisir();
        $dessin->setLibelle("Dessin/Peinture/Aquarelle");
        $dessin->setCategorie("Loisirs créatifs");
        $manager->persist($dessin);
        
        $ecriture = new Loisir();
        $ecriture->setLibelle("Ecriture");
        $ecriture->setCategorie("Loisirs créatifs");
        $manager->persist($ecriture);
        
        $instrument = new Loisir();
        $instrument->setLibelle("Instrument");
        $instrument->setCategorie("Loisirs créatifs");
        $manager->persist($instrument);
        
        $jvBis = new Loisir();
        $jvBis->setLibelle("Jeux vidéo");
        $jvBis->setCategorie("Loisirs créatifs");
        $manager->persist($jvBis);
        
        $photo = new Loisir();
        $photo->setLibelle("Photographie");
        $photo->setCategorie("Loisirs créatifs");
        $manager->persist($photo);
        
        $videos = new Loisir();
        $videos->setLibelle("Vidéos");
        $videos->setCategorie("Loisirs créatifs");
        $manager->persist($videos);
        
        // Sorties sociales
        $balades = new Loisir();
        $balades->setLibelle("Balades/Montagne");
        $balades->setCategorie("Sorties sociales");
        $manager->persist($balades);
        
        $fetes = new Loisir();
        $fetes->setLibelle("Fêtes/Jeudis soir");
        $fetes->setCategorie("Sorties sociales");
        $manager->persist($fetes);
        
        $plage = new Loisir();
        $plage->setLibelle("Plage");
        $plage->setCategorie("Sorties sociales");
        $manager->persist($plage);
        
        $restau = new Loisir();
        $restau->setLibelle("Restaurant");
        $restau->setCategorie("Sorties sociales");
        $manager->persist($restau);
        
        $ville = new Loisir();
        $ville->setLibelle("Ville");
        $ville->setCategorie("Sorties sociales");
        $manager->persist($ville);
        
        // Sorties culturelles
        $cine = new Loisir();
        $cine->setLibelle("Cinéma");
        $cine->setCategorie("Sorties culturelles");
        $manager->persist($cine);
        
        $concerts = new Loisir();
        $concerts->setLibelle("Concerts");
        $concerts->setCategorie("Sorties culturelles");
        $manager->persist($concerts);
        
        $musees = new Loisir();
        $musees->setLibelle("Musées/Expositions");
        $musees->setCategorie("Sorties culturelles");
        $manager->persist($musees);
        
        $theatreBis = new Loisir();
        $theatreBis->setLibelle("Théâtre");
        $theatreBis->setCategorie("Sorties culturelles");
        $manager->persist($theatreBis);
        
        
        /* *******************/
        /* CREATION Matières */
        /* *******************/
        
        $algorithmique = new Matiere();
        $algorithmique->setLibelle("Algorithmique");
        $algorithmique->setCategorie("Informatique");
        $manager->persist($algorithmique);
        
        $programmation = new Matiere();
        $programmation->setLibelle("Programmation");
        $programmation->setCategorie("Informatique");
        $manager->persist($programmation);
        
        $web = new Matiere();
        $web->setLibelle("Web");
        $web->setCategorie("Informatique");
        $manager->persist($web);
        
        $reseau = new Matiere();
        $reseau->setLibelle("Réseau");
        $reseau->setCategorie("Informatique");
        $manager->persist($reseau);
        
        $bd = new Matiere();
        $bd->setLibelle("Base de données");
        $bd->setCategorie("Informatique");
        $manager->persist($bd);
        
        $systeme = new Matiere();
        $systeme->setLibelle("Système");
        $systeme->setCategorie("Informatique");
        $manager->persist($systeme);
        
        $microControlleur = new Matiere();
        $microControlleur->setLibelle("MicroControlleur");
        $microControlleur->setCategorie("Informatique");
        $manager->persist($microControlleur);
        
        $cCpp = new Matiere();
        $cCpp->setLibelle("C/C++");
        $cCpp->setCategorie("Langage");
        $manager->persist($cCpp);
        
        $java = new Matiere();
        $java->setLibelle("Java");
        $java->setCategorie("Langage");
        $manager->persist($java);
        
        $php = new Matiere();
        $php->setLibelle("Php");
        $php->setCategorie("Langage");
        $manager->persist($php);
        
        $shellScript = new Matiere();
        $shellScript->setLibelle("Shell Script");
        $shellScript->setCategorie("Langage");
        $manager->persist($shellScript);
        
        $vba = new Matiere();
        $vba->setLibelle("VBA");
        $vba->setCategorie("Langage");
        $manager->persist($vba);
        
        $htmlCss = new Matiere();
        $htmlCss->setLibelle("Html / Css");
        $htmlCss->setCategorie("Langage");
        $manager->persist($htmlCss);
        
        $javaScript = new Matiere();
        $javaScript->setLibelle("JavaScript");
        $javaScript->setCategorie("Langage");
        $manager->persist($javaScript);
        
        $android = new Matiere();
        $android->setLibelle("Android");
        $android->setCategorie("Langage");
        $manager->persist($android);
        
        $cordova = new Matiere();
        $cordova->setLibelle("Cordova");
        $cordova->setCategorie("Langage");
        $manager->persist($cordova);
        
        $scheme = new Matiere();
        $scheme->setLibelle("Scheme");
        $scheme->setCategorie("Langage");
        $manager->persist($scheme);
        
        $mathematiques = new Matiere();
        $mathematiques->setLibelle("Mathématiques");
        $mathematiques->setCategorie("Autre");
        $manager->persist($mathematiques);
        
        $anglais = new Matiere();
        $anglais->setLibelle("Anglais");
        $anglais->setCategorie("Autre");
        $manager->persist($anglais);
        
        $communication = new Matiere();
        $communication->setLibelle("Communication");
        $communication->setCategorie("Autre");
        $manager->persist($communication);
        
        $economie = new Matiere();
        $economie->setLibelle("Economie");
        $economie->setCategorie("Autre");
        $manager->persist($economie);
        
        $droitDesTIC = new Matiere();
        $droitDesTIC->setLibelle("Droit des TIC");
        $droitDesTIC->setCategorie("Autre");
        $manager->persist($droitDesTIC);
        
        $organisationDesEntreprises = new Matiere();
        $organisationDesEntreprises->setLibelle("Organisation des entreprises");
        $organisationDesEntreprises->setCategorie("Autre");
        $manager->persist($organisationDesEntreprises);
        
        $comptabilite = new Matiere();
        $comptabilite->setLibelle("Comptabilité");
        $comptabilite->setCategorie("Autre");
        $manager->persist($comptabilite);
        
        $gestionDesSI = new Matiere();
        $gestionDesSI->setLibelle("Gestion des SI");
        $gestionDesSI->setCategorie("Autre");
        $manager->persist($gestionDesSI);
        
        
        

        /* ******************/
        /* CREATION Quentin */
        /* ******************/

        $quentin = new Etudiant();
        $quentin->setLogin("qlanusse");
        $quentin->setEstBDE(true);
        $quentin->setEstAdmin(true);
        $quentin->setNom("Lanusse");
        $quentin->setPrenom("Quentin");
        $quentin->setSexe('M');
        $quentin->setNumAnnee("2");
        $quentin->setDescription("Description de Quentin.");
        $quentin->setPhoto("user.png");
        $quentin->setNbDemandesValidees(1);
        $manager->persist($quentin);
        
        
        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        $manager->flush();
    }
}