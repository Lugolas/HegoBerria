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
        
        $basket = new Sport();
        $basket->setLibelle("BasketBall");
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
        


        
        
        /* ***************************/
        /* CREATION MATIERE FORTE 1  */
        /* ***************************/
        
        $BDForte = new MatiereForte();
        $BDForte->setLibelle("Base de données");
        $BDForte->setCategorie("Informatique");
        // On rend la matiere forte persistante pour pouvoir y faire référence ensuite
        $manager->persist($BDForte);
        
        /* ***************************/
        /* CREATION MATIERE FORTE 2  */
        /* ***************************/
        
        $programmationForte = new MatiereForte();
        $programmationForte->setLibelle("Programmation");
        $programmationForte->setCategorie("Informatique");
        // On rend la matiere forte persistante pour pouvoir y faire référence ensuite
        $manager->persist($programmationForte);
        
        /* ***************************/
        /* CREATION MATIERE FORTE 3  */
        /* ***************************/
        
        $bureautiqueForte = new MatiereForte();
        $bureautiqueForte->setLibelle("Bureautique");
        $bureautiqueForte->setCategorie("Informatique");
        // On rend la matiere faible persistante pour pouvoir y faire référence ensuite
        $manager->persist($bureautiqueForte);
        
        /* ***************************/
        /* CREATION MATIERE FORTE 4  */
        /* ***************************/
        
        $reseauFort = new MatiereForte();
        $reseauFort->setLibelle("Réseau");
        $reseauFort->setCategorie("Informatique");
        // On rend la matiere faible persistante pour pouvoir y faire référence ensuite
        $manager->persist($reseauFort);
        



        
        /* ***************************/
        /* CREATION MATIERE FAIBLE 1 */
        /* ***************************/
        
        $bureautiqueFaible = new MatiereFaible();
        $bureautiqueFaible->setLibelle("Bureautique");
        $bureautiqueFaible->setCategorie("Informatique");
        // On rend la matiere faible persistante pour pouvoir y faire référence ensuite
        $manager->persist($bureautiqueFaible);
        
        /* ***************************/
        /* CREATION MATIERE FAIBLE 2  */
        /* ***************************/
        
        $reseauFaible = new MatiereFaible();
        $reseauFaible->setLibelle("Réseau");
        $reseauFaible->setCategorie("Informatique");
        // On rend la matiere faible persistante pour pouvoir y faire référence ensuite
        $manager->persist($reseauFaible);
        
        /* ***************************/
        /* CREATION MATIERE FAIBLE 3 */
        /* ***************************/
        
        $BDFaible = new MatiereFaible();
        $BDFaible->setLibelle("Base de données");
        $BDFaible->setCategorie("Informatique");
        // On rend la matiere forte persistante pour pouvoir y faire référence ensuite
        $manager->persist($BDFaible);
        
        /* ***************************/
        /* CREATION MATIERE FAIBLE 4 */
        /* ***************************/
        
        $programmationFaible = new MatiereFaible();
        $programmationFaible->setLibelle("Programmation");
        $programmationFaible->setCategorie("Informatique");
        // On rend la matiere faible persistante pour pouvoir y faire référence ensuite
        $manager->persist($programmationFaible);
        



        /* *********************/
        /* CREATION ETUDIANT 1 */
        /* *********************/

        $etudiant = new Etudiant();
        $etudiant->setLogin("ccaillet");
        $etudiant->setEstBDE(true);
        $etudiant->setEstAdmin(false);
        $etudiant->setNom("Caillet");
        $etudiant->setPrenom("XxDarkClaudia64xX");
        $etudiant->setSexe('F');
        $etudiant->setNumAnnee("2");
        $etudiant->setDescription("Cette description n'est là que pour être assez longue pour pouvoir voir comment ça rend. Du coup, Je suis Claudia, je fais de l'escalade, je joue aux jeux vidéos, je mange des raclettes, je lis des mangas, je dessine, j'écris, je dors, je mange des bonbons, je dors, je suis méchante, je tape Hugo mon sous-fifre de 1ere année.");
        $etudiant->setPhoto("student1.jpg");
        $etudiant->addMatiereForte($BDForte);
        $etudiant->addMatiereForte($programmationForte);
        $etudiant->addMatiereFaible($bureautiqueFaible);
        $etudiant->addSport($etudiantSport = new EtudiantSport(), $basket);
        $etudiant->addLoisir($etudiantLoisir = new EtudiantLoisir(), $roman);
        
        
        $manager->persist($etudiantLoisir);
        $manager->persist($etudiantSport);
        
        $etudiant->addSport($etudiantSport = new EtudiantSport(), $artsMartiaux, "J'te pète la gueule !");
        $etudiant->addLoisir($etudiantLoisir = new EtudiantLoisir(), $films);
        
        $manager->persist($etudiantLoisir);
        $manager->persist($etudiantSport);
        
        $etudiant->addSport($etudiantSport = new EtudiantSport(), $handball, "Le handball, c'est trop d'la balle !!!");
        $etudiant->addLoisir($etudiantLoisir = new EtudiantLoisir(), $JDR);
        
        $manager->persist($etudiantLoisir);
        $manager->persist($etudiantSport);
        
        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($etudiant);
        
        /* *********************/
        /* CREATION ETUDIANT 2 */
        /* *********************/


        $etudiant = new Etudiant();
        $etudiant->setLogin("hsmenaut");
        $etudiant->setEstBDE(false);
        $etudiant->setEstAdmin(false);
        $etudiant->setNom("Sallebert--Menaut");
        $etudiant->setPrenom("Hugo");
        $etudiant->setSexe('M');
        $etudiant->setNumAnnee("1");
        $etudiant->setDescription("Salut, moi c'est Lhugobert, l'archer Elfe des temps modernes armé de son fidèle bouclier, on me mieux sous le nom de Captain Amérindia ! Eh oui je suis un vrai héro ;) Et malgré mon statut de 1° année je gère une bande de bras cassés de 2° années pour faire leur site web");
        $etudiant->setPhoto("student2.jpg");
        $etudiant->addMatiereForte($programmationForte);
        $etudiant->addMatiereFaible($bureautiqueFaible);
        $etudiant->addSport($etudiantSport = new EtudiantSport(),$basket, "Je sais meme pas pourquoi je m'y suis inscrit");
        $etudiant->addLoisir($etudiantLoisir = new EtudiantLoisir(),$animes, "Tiens, faudrait que je finisse shigatsu moi...");
        
        
        $manager->persist($etudiantLoisir);
        $manager->persist($etudiantSport);
        
        $etudiant->addSport($etudiantSport = new EtudiantSport(), $artsMartiaux, "Krab-Fu");
        $etudiant->addLoisir($etudiantLoisir = new EtudiantLoisir(), $JDR, "Trop fun de ouf maggle !");
        
        $manager->persist($etudiantLoisir);
        $manager->persist($etudiantSport);
        
        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($etudiant); 
        
        /* *********************/
        /* CREATION ETUDIANT 3 */
        /* *********************/


        $etudiant = new Etudiant();
        $etudiant->setLogin("vmartinet");
        $etudiant->setEstBDE(true);
        $etudiant->setEstAdmin(true);
        $etudiant->setNom("Martinet");
        $etudiant->setPrenom("Vincent");
        $etudiant->setSexe('M');
        $etudiant->setNumAnnee("2");
        $etudiant->setDescription("Mon papa, c'est Pierre Martinet ! En passant je suis le meilleurs joueur de DeautaDe de la région de Kanto ! En plus je suis gros parce que je fais pas de sport.");
        $etudiant->setPhoto("student3.jpg");
        $etudiant->addMatiereForte($BDForte);
        $etudiant->addMatiereFaible($reseauFaible);
        $etudiant->addMatiereFaible($bureautiqueFaible);
        $etudiant->addMatiereFaible($programmationFaible);
        $etudiant->addLoisir($etudiantLoisir = new EtudiantLoisir(),$roman, "Pire loisir de la Terre");
        $etudiant->addSport($etudiantSport = new EtudiantSport(), $pasDeSport, "Le sport c'est pour les tarlouzes");
        
        
        $manager->persist($etudiantLoisir);
        $manager->persist($etudiantSport);
        
        $etudiant->addLoisir($etudiantLoisir = new EtudiantLoisir(),$fetesJeudisSoir);
        
        $manager->persist($etudiantLoisir);
        
        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($etudiant);
        
        /* *********************/
        /* CREATION ETUDIANT 4 */
        /* *********************/


        $etudiant = new Etudiant();
        $etudiant->setLogin("qlanusse");
        $etudiant->setEstBDE(true);
        $etudiant->setEstAdmin(false);
        $etudiant->setNom("Lanusse");
        $etudiant->setPrenom("Quentin");
        $etudiant->setSexe('M');
        $etudiant->setNumAnnee("2");
        $etudiant->setDescription("Salut, moi c'est Quentin.");
        $etudiant->setPhoto("student4.jpg");
        $etudiant->addMatiereForte($programmationForte);
        $etudiant->addMatiereFaible($reseauFaible);
        $etudiant->addSport($etudiantSport = new EtudiantSport(), $basket, "Pas terrible comme sport");
        $etudiant->addLoisir($etudiantLoisir = new EtudiantLoisir(), $animes);
        

        $manager->persist($etudiantSport);
        $manager->persist($etudiantLoisir);
        
        $etudiant->addSport($etudiantSport = new EtudiantSport(),$athletisme, "Je serai bientôt le roi des pirates !");
        
        $manager->persist($etudiantSport);
        
        // On rend l'étudiant persistant pour pouvoir y faire référence ensuite
        $manager->persist($etudiant);
 

 
        
        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        // On déclenche l'enregistrement de tous les stages,formations et entreprises en BD
        $manager->flush();
    }
}