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
        
        /* *********************/
        /* CREATION SPORT 1    */
        /* *********************/
        
        $basket = new Sport();
        $basket->setLibelle("Basketball");
        $basket->setCategorie("A plusieurs/Equipe");
        // On rend le sport persistant pour pouvoir y faire référence ensuite
        $manager->persist($basket);
        
        /* *********************/
        /* CREATION SPORT 2    */
        /* *********************/
        
        $bowling = new Sport();
        $bowling->setLibelle("Bowling");
        $bowling->setCategorie("Solos");
        // On rend le sport persistant pour pouvoir y faire référence ensuite
        $manager->persist($bowling);
        
        /* *********************/
        /* CREATION SPORT 3    */
        /* *********************/
        
        $athletisme = new Sport();
        $athletisme->setLibelle("Athlétisme");
        $athletisme->setCategorie("Solos");
        // On rend le sport persistant pour pouvoir y faire référence ensuite
        $manager->persist($athletisme);
        
        /* *********************/
        /* CREATION SPORT 4    */
        /* *********************/
        
        $handball = new Sport();
        $handball->setLibelle("Handball");
        $handball->setCategorie("A plusieurs/Equipe");
        // On rend le sport persistant pour pouvoir y faire référence ensuite
        $manager->persist($handball);
        
        /* *********************/
        /* CREATION SPORT 5    */
        /* *********************/
        
        $artsMartiaux = new Sport();
        $artsMartiaux->setLibelle("Arts martiaux");
        $artsMartiaux->setCategorie("Solos");
        // On rend le sport persistant pour pouvoir y faire référence ensuite
        $manager->persist($artsMartiaux);
        
        /* *********************/
        /* CREATION PasDeSport    */
        /* *********************/
        
        $pasDeSport = new Sport();
        $pasDeSport->setLibelle("Aucun sport");
        $pasDeSport->setCategorie("Autre");
        // On rend le sport persistant pour pouvoir y faire référence ensuite
        $manager->persist($pasDeSport);
        

        
        
        /* *********************/
        /* CREATION LOISIR   1 */
        /* *********************/
        
        $animes = new Loisir();
        $animes->setLibelle("Animes");
        $animes->setCategorie("Audiovisuel");
        // On rend le loisir persistant pour pouvoir y faire référence ensuite
        $manager->persist($animes);
        
        
        /* *********************/
        /* CREATION LOISIR   2 */
        /* *********************/
        
        $roman = new Loisir();
        $roman->setLibelle("Romans");
        $roman->setCategorie("Lecture");
        // On rend le loisir persistant pour pouvoir y faire référence ensuite
        $manager->persist($roman);
        
        /* *********************/
        /* CREATION LOISIR   3 */
        /* *********************/
        
        $films = new Loisir();
        $films->setLibelle("Films");
        $films->setCategorie("Audiovisuel");
        // On rend le loisir persistant pour pouvoir y faire référence ensuite
        $manager->persist($films);
        
        /* *********************/
        /* CREATION LOISIR   4 */
        /* *********************/
        
        $fetesJeudisSoir = new Loisir();
        $fetesJeudisSoir->setLibelle("Fêtes - Jeudis soir");
        $fetesJeudisSoir->setCategorie("Sorties sociales");
        // On rend le loisir persistant pour pouvoir y faire référence ensuite
        $manager->persist($fetesJeudisSoir);
        
        /* *********************/
        /* CREATION LOISIR   5 */
        /* *********************/
        
        $JDR = new Loisir();
        $JDR->setLibelle("Jeux de rôles");
        $JDR->setCategorie("Jeux");
        // On rend le loisir persistant pour pouvoir y faire référence ensuite
        $manager->persist($JDR);
        


        
        
        /* *********************/
        /* CREATION MATIERE 1  */
        /* *********************/
        
        $BD = new Matiere();
        $BD->setLibelle("Base de données");
        $BD->setCategorie("Informatique");
        // On rend la matiere forte persistante pour pouvoir y faire référence ensuite
        $manager->persist($BD);
        
        /* *********************/
        /* CREATION MATIERE 2  */
        /* *********************/
        
        $programmation = new Matiere();
        $programmation->setLibelle("Programmation");
        $programmation->setCategorie("Informatique");
        // On rend la matiere forte persistante pour pouvoir y faire référence ensuite
        $manager->persist($programmation);
        
        /* *********************/
        /* CREATION MATIERE 3  */
        /* *********************/
        
        $bureautique = new Matiere();
        $bureautique->setLibelle("Bureautique");
        $bureautique->setCategorie("Informatique");
        // On rend la matiere faible persistante pour pouvoir y faire référence ensuite
        $manager->persist($bureautique);
        
        /* *********************/
        /* CREATION MATIERE 4  */
        /* *********************/
        
        $reseau = new Matiere();
        $reseau->setLibelle("Réseau");
        $reseau->setCategorie("Informatique");
        // On rend la matiere faible persistante pour pouvoir y faire référence ensuite
        $manager->persist($reseau);
        





        /* *********************/
        /* CREATION ETUDIANT 1 */
        /* *********************/

        $claudia = new Etudiant();
        $claudia->setLogin("ccaillet");
        $claudia->setEstBDE(true);
        $claudia->setEstAdmin(false);
        $claudia->setNom("Caillet");
        $claudia->setPrenom("Claudia");
        $claudia->setSexe('F');
        $claudia->setNumAnnee("2");
        $claudia->setDescription("Description de Claudia.");
        $claudia->setPhoto("student1.jpg");

        
        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($claudia);
        
        /* *********************/
        /* CREATION ETUDIANT 2 */
        /* *********************/


        $hugo = new Etudiant();
        $hugo->setLogin("hsmenaut");
        $hugo->setEstBDE(false);
        $hugo->setEstAdmin(false);
        $hugo->setNom("Sallebert--Menaut");
        $hugo->setPrenom("Hugo");
        $hugo->setSexe('M');
        $hugo->setNumAnnee("1");
        $hugo->setDescription("Description de Hugo");
        $hugo->setPhoto("student2.jpg");

        
        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($hugo); 
        
        /* *********************/
        /* CREATION ETUDIANT 3 */
        /* *********************/


        $vincent = new Etudiant();
        $vincent->setLogin("vmartinet");
        $vincent->setEstBDE(true);
        $vincent->setEstAdmin(true);
        $vincent->setNom("Martinet");
        $vincent->setPrenom("Vincent");
        $vincent->setSexe('M');
        $vincent->setNumAnnee("2");
        $vincent->setDescription("Description de Vincent.");
        $vincent->setPhoto("student3.jpg");

        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($vincent);
        
        /* *********************/
        /* CREATION ETUDIANT 4 */
        /* *********************/


        $quentin = new Etudiant();
        $quentin->setLogin("qlanusse");
        $quentin->setEstBDE(true);
        $quentin->setEstAdmin(false);
        $quentin->setNom("Lanusse");
        $quentin->setPrenom("Quentin");
        $quentin->setSexe('M');
        $quentin->setNumAnnee("2");
        $quentin->setDescription("Description de Quentin.");
        $quentin->setPhoto("student4.jpg");

        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($quentin);
 


        /* ************************** */
        /* CREATION DemandeParrainage */
        /* ************************** */

        $lien = new DemandeParrainage($vincent, $hugo);
        $manager->persist($lien);
        
        
        $lien = new DemandeParrainage($quentin, $hugo, true);
        $manager->persist($lien);



 
        /* ******************************** */
        /* CREATION EtudiantLoisirs Claudia */
        /* ******************************** */
        
        $etudiantLoisir = new EtudiantLoisir($claudia, $roman);
        $manager->persist($etudiantLoisir);
        
        $etudiantLoisir = new EtudiantLoisir($claudia, $films);
        $manager->persist($etudiantLoisir);
        
        $etudiantLoisir = new EtudiantLoisir($claudia, $JDR);
        $manager->persist($etudiantLoisir);
        
        
        
        /* ******************************* */
        /* CREATION EtudiantSports Claudia */
        /* ******************************* */
        
        $etudiantSport = new EtudiantSport($claudia, $basket);
        $manager->persist($etudiantSport);
        
        $etudiantSport = new EtudiantSport($claudia, $artsMartiaux, 'Ceinture noire !');
        $manager->persist($etudiantSport);
        
        $etudiantSport = new EtudiantSport($claudia, $handball, 'Top !');
        $manager->persist($etudiantSport);



        /* *************************************** */
        /* CREATION EtudiantMatiereFaibles Claudia */
        /* *************************************** */
    
        $etudiantMatiereFaible = new EtudiantMatiereFaible($claudia, $bureautique);
        $manager->persist($etudiantMatiereFaible);



        /* ************************************** */
        /* CREATION EtudiantMatiereFortes Claudia */
        /* ************************************** */

        $etudiantMatiereForte = new EtudiantMatiereForte($claudia, $BD);
        $manager->persist($etudiantMatiereForte);
        
        $etudiantMatiereForte = new EtudiantMatiereForte($claudia, $programmation);
        $manager->persist($etudiantMatiereForte);
        
        
        /* ********************* */
        /* CREATION Lien Claudia */
        /* ********************* */
        
        $lien = new Lien($claudia, 'LinkedIn', 'https://fr.linkedin.com/');
        $manager->persist($lien);
        
        $lien = new Lien($claudia, 'Iut de Bayonne et du pays basque', 'http://www.iutbayonne.univ-pau.fr/');
        $manager->persist($lien);
        
        
        
        
        
        
        
        
        /* ***************************** */
        /* CREATION EtudiantLoisirs Hugo */
        /* ***************************** */
        
        $etudiantLoisir = new EtudiantLoisir($hugo, $animes, "C'est bien");
        $manager->persist($etudiantLoisir);
        
        $etudiantLoisir = new EtudiantLoisir($hugo, $JDR, "Trop fun !");
        $manager->persist($etudiantLoisir);
        
        
        
        /* **************************** */
        /* CREATION EtudiantSports Hugo */
        /* **************************** */
        
        $etudiantSport = new EtudiantSport($hugo, $basket, "Je sais meme pas pourquoi je m'y suis inscrit");
        $manager->persist($etudiantSport);
        
        $etudiantSport = new EtudiantSport($hugo, $artsMartiaux, "Krab-Fu");
        $manager->persist($etudiantSport);



        /* ************************************ */
        /* CREATION EtudiantMatiereFaibles Hugo */
        /* ************************************ */
    
        $etudiantMatiereFaible = new EtudiantMatiereFaible($hugo, $bureautique);
        $manager->persist($etudiantMatiereFaible);



        /* *********************************** */
        /* CREATION EtudiantMatiereFortes Hugo */
        /* *********************************** */

        $etudiantMatiereForte = new EtudiantMatiereForte($hugo, $programmation);
        $manager->persist($etudiantMatiereForte);
        
        
        /* ****************** */
        /* CREATION Lien Hugo */
        /* ****************** */
        
        $lien = new Lien($hugo, 'Endless Legend', 'http://www.amplitude-studios.com/endless-legend');
        $manager->persist($lien);
        
        $lien = new Lien($hugo, 'Youtube', 'https://www.youtube.com/');
        $manager->persist($lien);
        
        
        
 
 


        /* ******************************** */
        /* CREATION EtudiantLoisirs Vincent */
        /* ******************************** */
        
        $etudiantLoisir = new EtudiantLoisir($vincent, $roman, "Pire loisir de la Terre");
        $manager->persist($etudiantLoisir);
        
        $etudiantLoisir = new EtudiantLoisir($vincent, $fetesJeudisSoir);
        $manager->persist($etudiantLoisir);
        
        
        
        /* ******************************* */
        /* CREATION EtudiantSports Vincent */
        /* ******************************* */
        
        $etudiantSport = new EtudiantSport($vincent, $pasDeSport, "J'aime pas le sport");
        $manager->persist($etudiantSport);



        /* *************************************** */
        /* CREATION EtudiantMatiereFaibles Vincent */
        /* *************************************** */
    
        $etudiantMatiereFaible = new EtudiantMatiereFaible($vincent, $reseau);
        $manager->persist($etudiantMatiereFaible);
        
        $etudiantMatiereFaible = new EtudiantMatiereFaible($vincent, $bureautique);
        $manager->persist($etudiantMatiereFaible);
        
        $etudiantMatiereFaible = new EtudiantMatiereFaible($vincent, $programmation);
        $manager->persist($etudiantMatiereFaible);



        /* ************************************** */
        /* CREATION EtudiantMatiereFortes Vincent */
        /* ************************************** */

        $etudiantMatiereForte = new EtudiantMatiereForte($vincent, $BD);
        $manager->persist($etudiantMatiereForte);
        
        /* ********************* */
        /* CREATION Lien Vincent */
        /* ********************* */
        
        $lien = new Lien($vincent, 'DOTA2', 'http://fr.dota2.com/');
        $manager->persist($lien);
        
        $lien = new Lien($vincent, 'Facebook', 'https://fr-fr.facebook.com/');
        $manager->persist($lien);
 
 
 
 
 
 
 

        /* ******************************** */
        /* CREATION EtudiantLoisirs Quentin */
        /* ******************************** */
        
        $etudiantLoisir = new EtudiantLoisir($quentin, $animes);
        $manager->persist($etudiantLoisir);
        
        
        
        /* ******************************* */
        /* CREATION EtudiantSports Quentin */
        /* ******************************* */
        
        $etudiantSport = new EtudiantSport($quentin, $basket, "Pas terrible comme sport");
        $manager->persist($etudiantSport);
        
        $etudiantSport = new EtudiantSport($quentin, $athletisme);
        $manager->persist($etudiantSport);



        /* *************************************** */
        /* CREATION EtudiantMatiereFaibles Quentin */
        /* *************************************** */
    
        $etudiantMatiereFaible = new EtudiantMatiereFaible($quentin, $reseau);
        $manager->persist($etudiantMatiereFaible);



        /* ************************************** */
        /* CREATION EtudiantMatiereFortes Quentin */
        /* ************************************** */

        $etudiantMatiereForte = new EtudiantMatiereForte($quentin, $programmation);
        $manager->persist($etudiantMatiereForte);

 
 
        /* ********************* */
        /* CREATION Lien Quentin */
        /* ********************* */
        
        $lien = new Lien($quentin, 'Cloud9', 'https://c9.io/qlanusse');
        $manager->persist($lien);
        
        $lien = new Lien($quentin, 'Facebook', 'https://fr-fr.facebook.com/');
        $manager->persist($lien);
        
        
        
        
 
        
        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        // On déclenche l'enregistrement de tous les stages,formations et entreprises en BD
        $manager->flush();
    }
}