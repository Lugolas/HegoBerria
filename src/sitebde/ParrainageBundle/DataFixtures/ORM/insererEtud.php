<?php
// src/sitebde/ParrainageBundle/DataFixtures/ORM/insererEtud.php

namespace sitebde\ParrainageBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use sitebde\ParrainageBundle\Entity\Activite;
use sitebde\ParrainageBundle\Entity\Etudiant;
use sitebde\ParrainageBundle\Entity\Loisir;
use sitebde\ParrainageBundle\Entity\Matiere;
use sitebde\ParrainageBundle\Entity\MatiereFaible;
use sitebde\ParrainageBundle\Entity\MatiereForte;
use sitebde\ParrainageBundle\Entity\Sport;
use sitebde\ParrainageBundle\Entity\EtudiantSport;
use sitebde\ParrainageBundle\Entity\EtudiantLoisir;

class Etudiants  implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        /* *********************/
        /* CREATION SPORT 1    */
        /* *********************/
        
        $sportun = new Sport();
        $sportun->setLibelle("Handball");
        $sportun->setCategorie("A plusieurs/Equipe");
        // On rend le sport persistant pour pouvoir y faire référence ensuite
        $manager->persist($sportun);
        
        /* *********************/
        /* CREATION SPORT 2    */
        /* *********************/
        
        $sportdeux = new Sport();
        $sportdeux->setLibelle("Bowling");
        $sportdeux->setCategorie("Solos");
        // On rend le sport persistant pour pouvoir y faire référence ensuite
        $manager->persist($sportdeux);
        
        
        /* *********************/
        /* CREATION LOISIR   1 */
        /* *********************/
        
        $loisirun = new Loisir();
        $loisirun->setLibelle("Animes");
        $loisirun->setCategorie("Activités audiovisuelles");
        // On rend le loisir persistant pour pouvoir y faire référence ensuite
        $manager->persist($loisirun);
        
        
        /* *********************/
        /* CREATION LOISIR   2 */
        /* *********************/
        
        $loisirdeux = new Loisir();
        $loisirdeux->setLibelle("Lecture");
        $loisirdeux->setCategorie("Romans");
        // On rend le loisir persistant pour pouvoir y faire référence ensuite
        $manager->persist($loisirdeux);
        
        
        /* ***************************/
        /* CREATION MATIERE FORTE 1  */
        /* ***************************/
        
        $matiereforteun = new MatiereForte();
        $matiereforteun->setLibelle("Base de données");
        $matiereforteun->setCategorie("Informatique");
        // On rend la matiere forte persistante pour pouvoir y faire référence ensuite
        $manager->persist($matiereforteun);
        
        /* ***************************/
        /* CREATION MATIERE FORTE 2  */
        /* ***************************/
        
        $matierefortedeux = new MatiereForte();
        $matierefortedeux->setLibelle("Programmation");
        $matierefortedeux->setCategorie("Informatique");
        // On rend la matiere forte persistante pour pouvoir y faire référence ensuite
        $manager->persist($matierefortedeux);
        
        /* ***************************/
        /* CREATION MATIERE FAIBLE 1 */
        /* ***************************/
        
        $matierefaibleun = new MatiereFaible();
        $matierefaibleun->setLibelle("Bureautique");
        $matierefaibleun->setCategorie("Informatique");
        // On rend la matiere faible persistante pour pouvoir y faire référence ensuite
        $manager->persist($matierefaibleun);
        
        /* ***************************/
        /* CREATION MATIERE FAIBLE 2  */
        /* ***************************/
        
        $matierefaibledeux = new MatiereFaible();
        $matierefaibledeux->setLibelle("Réseau");
        $matierefaibledeux->setCategorie("Informatique");
        // On rend la matiere faible persistante pour pouvoir y faire référence ensuite
        $manager->persist($matierefortedeux);

        /* *********************/
        /* CREATION ETUDIANT 1 */
        /* *********************/


        $etudiantNumeroUn = new Etudiant();
        $etudiantNumeroUn->setLogin("etud1");
        $etudiantNumeroUn->setEstBDE("true");
        $etudiantNumeroUn->setEstAdmin("false");
        $etudiantNumeroUn->setNom("Etudiantun");
        $etudiantNumeroUn->setPrenom("Petudun");
        $etudiantNumeroUn->setSexe('M');
        $etudiantNumeroUn->setNumAnnee("2");
        $etudiantNumeroUn->setDescription("Description  etudiant 1");
        $etudiantNumeroUn->setPhoto("student1.jpg");
        $etudiantNumeroUn->addMatiereForte($matiereforteun);
        $etudiantNumeroUn->addMatiereFaible($matierefaibleun);
        $etudiantNumeroUn->addSport(new EtudiantSport(),$sportun);
        $etudiantNumeroUn->addLoisir(new EtudiantLoisir(),$loisirdeux);
        
        
        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($etudiantNumeroUn);
        
        /* *********************/
        /* CREATION ETUDIANT 2 */
        /* *********************/


        $etudiantNumeroDeux = new Etudiant();
        $etudiantNumeroDeux->setLogin("etud2");
        $etudiantNumeroDeux->setEstBDE("false");
        $etudiantNumeroDeux->setEstAdmin("false");
        $etudiantNumeroDeux->setNom("Etudiantdeux");
        $etudiantNumeroDeux->setPrenom("Petuddeux");
        $etudiantNumeroDeux->setSexe('F');
        $etudiantNumeroDeux->setNumAnnee("1");
        $etudiantNumeroDeux->setDescription("Description  etudiant 2");
        $etudiantNumeroDeux->setPhoto("student2.jpg");
        $etudiantNumeroDeux->addMatiereForte($matierefortedeux);
        $etudiantNumeroDeux->addMatiereFaible($matierefaibleun);
        $etudiantNumeroDeux->addSport(new EtudiantSport(),$sportdeux,"Je sais meme pas pourquoi je m'y suis inscrit");
        $etudiantNumeroDeux->addLoisir(new EtudiantLoisir(),$loisirun,"Trop fun !!! Jacques");
        
        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($etudiantNumeroDeux);
        
        /* *********************/
        /* CREATION ETUDIANT 3 */
        /* *********************/


        $etudiantNumeroTrois = new Etudiant();
        $etudiantNumeroTrois->setLogin("etud3");
        $etudiantNumeroTrois->setEstBDE("true");
        $etudiantNumeroTrois->setEstAdmin("true");
        $etudiantNumeroTrois->setNom("Etudianttrois");
        $etudiantNumeroTrois->setPrenom("Petudtrois");
        $etudiantNumeroTrois->setSexe('M');
        $etudiantNumeroTrois->setNumAnnee("2");
        $etudiantNumeroTrois->setDescription("Description  etudiant 3");
        $etudiantNumeroTrois->setPhoto("student3.jpg");
        $etudiantNumeroTrois->addMatiereForte($matiereforteun);
        $etudiantNumeroTrois->addMatiereFaible($matierefaibledeux);
        $etudiantNumeroTrois->addSport(new EtudiantSport(),$sportun,"Sport permettant de devenir roi du Monde");
        $etudiantNumeroTrois->addLoisir(new EtudiantLoisir(),$loisirun,"Pire loisir de la Terre");
        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($etudiantNumeroTrois);
        
        /* *********************/
        /* CREATION ETUDIANT 4 */
        /* *********************/


        $etudiantNumeroQuatre = new Etudiant();
        $etudiantNumeroQuatre->setLogin("etud4");
        $etudiantNumeroQuatre->setEstBDE("true");
        $etudiantNumeroQuatre->setEstAdmin("false");
        $etudiantNumeroQuatre->setNom("Etudiantquatre");
        $etudiantNumeroQuatre->setPrenom("Petudquatre");
        $etudiantNumeroQuatre->setSexe('F');
        $etudiantNumeroQuatre->setNumAnnee("2");
        $etudiantNumeroQuatre->setDescription("Description  etudiant 4");
        $etudiantNumeroQuatre->setPhoto("student4.jpg");
        $etudiantNumeroQuatre->addMatiereForte($matierefortedeux);
        $etudiantNumeroQuatre->addMatiereFaible($matierefaibledeux);
        $etudiantNumeroQuatre->addSport(new EtudiantSport(),$sportun, "Pas terrible comme sport");
        $etudiantNumeroQuatre->addLoisir(new EtudiantLoisir(),$loisirun,"Loisir vraiment très fun");
        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($etudiantNumeroQuatre);
        
        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        // On déclenche l'enregistrement de tous les stages,formations et entreprises en BD
        $manager->flush();
    }
}