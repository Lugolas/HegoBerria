<?php
// src/sitebde/SiteVitrineBundle/DataFixtures/ORM/insererPubli.php

namespace sitebde\SiteVitrineBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use sitebde\SiteVitrineBundle\Entity\Actualite;
use sitebde\SiteVitrineBundle\Entity\Article;
use sitebde\SiteVitrineBundle\Entity\Evenement;
use sitebde\SiteVitrineBundle\Entity\Information;
use sitebde\SiteVitrineBundle\Entity\Publication;

class Publications  implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        /* ******************************************************* */
        /* CREATION EVENEMENT 1 ANNIVERSAIRE VINCENT MARTINET*/
        /* ******************************************************* */


        $evenementAnniversaireVincent = new Evenement();
        $evenementAnniversaireVincent->setTitre("C’est aujourd’hui l’anniversaire de Vincent Martinet !");
        $evenementAnniversaireVincent->setContenu("En ce dimanche 15 janvier 2017, nous fêtons les 20 ans du célèbre Vincent Martinet. Il nous fera l’honneur d’être à l’IUT pour signer quelques autographes et répondre à vos questions ! Alors n’hésitez pas, et venez le rencontrer !");        
        $evenementAnniversaireVincent->setDateActualisation(new \DateTime("2017-01-15"));
        $evenementAnniversaireVincent->setDatePublication(new \DateTime("2017-01-15"));
        $evenementAnniversaireVincent->setIcone('58bb155519899.png');
        $evenementAnniversaireVincent->setDateEvenement(new \DateTime("2017-01-15"));

        // On rend l'évènement persistant pour pouvoir y faire référence ensuite
        $manager->persist($evenementAnniversaireVincent);
        
        /* ****************************************/
        /* CREATION EVENEMENT 2 DEPART SUR LA LUNE*/
        /* ****************************************/


        $evenementDepartLune = new Evenement();
        $evenementDepartLune->setTitre("L'IUT se délocalise... sur la Lune !");
        $evenementDepartLune->setContenu("Equitis Romani autem esse filium criminis loco poni ab accusatoribus neque his iudicantibus oportuit neque defendentibus nobis. Nam quod de pietate dixistis, est quidem ista nostra existimatio, sed iudicium certe parentis; quid nos opinemur, audietis ex iuratis; quid parentes sentiant, lacrimae matris incredibilisque maeror, squalor patris et haec praesens maestitia, quam cernitis, luctusque declarat.");
        $evenementDepartLune->setDateActualisation(new \DateTime("2017-01-27"));
        $evenementDepartLune->setDatePublication(new \DateTime("2017-01-27"));
        $evenementDepartLune->setIcone('58bb153cb9f7f.jpg');
        $evenementDepartLune->setDateEvenement(new \DateTime("2020-01-15"));

        // On rend l'évènement persistant pour pouvoir y faire référence ensuite
        $manager->persist($evenementDepartLune);
        
        /* **************************************** */
        /* CREATION EVENEMENT 3 RETOUR SUR LA TERRE */
        /* **************************************** */


        $evenementRetourTerre = new Evenement();
        $evenementRetourTerre->setTitre("L'IUT revient sur Terre !");
        $evenementRetourTerre->setContenu("Post haec indumentum regale quaerebatur et ministris fucandae purpurae tortis confessisque pectoralem tuniculam sine manicis textam, Maras nomine quidam inductus est ut appellant Christiani diaconus, cuius prolatae litterae scriptae Graeco sermone ad Tyrii textrini praepositum celerari speciem perurgebant quam autem non indicabant denique etiam idem ad usque discrimen vitae vexatus nihil fateri conpulsus est.");
        $evenementRetourTerre->setDateActualisation(new \DateTime("2017-01-27"));
        $evenementRetourTerre->setDatePublication(new \DateTime("2017-01-27"));
        $evenementRetourTerre->setIcone('58bb1544a601f.jpg');
        $evenementRetourTerre->setDateEvenement(new \DateTime("2020-01-16"));

        // On rend l'évènement persistant pour pouvoir y faire référence ensuite
        $manager->persist($evenementRetourTerre);

        /* ******************************************************* */
        /* CREATION ACTUALITE 1 Prix Nobel de la Paix décerné à une élève de l’IUT !*/
        /* ******************************************************* */
        
        $actualitePrixPaixClaudia = new Actualite();
        $actualitePrixPaixClaudia->setTitre("Prix Nobel de la Paix décerné à une élève de l’IUT !");
        $actualitePrixPaixClaudia->setContenu("Vous avez bien lu ! En effet, la jeune femme qui a reçue le prix Nobel de la Paix se trouve être une étudiante de l’IUT de Bayonne ! Il s’agit, vous l’aurez deviné, de Claudia Caillet ! Dans son discours, elle a même cité l’IUT comme étant un lieu où elle s’apaiser au quotidien.");
        $actualitePrixPaixClaudia->setDateActualisation(new \DateTime("15-01-2017"));
        $actualitePrixPaixClaudia->setDatePublication(new \DateTime("15-01-2017"));
        $actualitePrixPaixClaudia->setIcone('58bb0f4da9509.png');
        
        // On rend l'actualite persistant pour pouvoir y faire référence ensuite
        $manager->persist($actualitePrixPaixClaudia);
        
         /* ******************************************************* */
        /* CREATION ACTUALITE 2 Un étudiant de l’IUT se retrouve malgré lui gagnant du LOTO !*/
        /* ******************************************************* */

        $actualiteEtudiantLoto = new Actualite();
        $actualiteEtudiantLoto->setTitre("Un étudiant de l’IUT se retrouve malgré lui gagnant du LOTO");
        $actualiteEtudiantLoto->setContenu("L’histoire se passe sur le chemin entre l’IUT et le restaurant universitaire. Un étudiant se prénommant Hugo (nous ne dévoilerons pas son nom de famille pour raison de confidentialité et de sécurité) se retrouve être l’heureux gagnant du LOTO. Il remporte ainsi la somme de 19 millions d’euros sans avoir joué ! Et oui en effet, Hugo n’a pas joué au LOTO. Il se trouve qu’il a ramassé ce ticket gagnant sur le chemin entre l’IUT et le restaurant universitaire. Dommage pour celui qui l’a perdu !");
        $actualiteEtudiantLoto->setDateActualisation(new \DateTime("14-01-2017"));
        $actualiteEtudiantLoto->setDatePublication(new \DateTime("10-01-2017"));
        $actualiteEtudiantLoto->setIcone("58bb0f650b2a2.png");
        
        // On rend l'actualite persistant pour pouvoir y faire référence ensuite
        $manager->persist($actualiteEtudiantLoto);
        
        /* **************************************************************** */
        /* CREATION ACTUALITE 3 La course, plus qu’une passion, une méthode.*/
        /* **************************************************************** */
        
        $actualiteCourseEtudes = new Actualite();
        $actualiteCourseEtudes->setTitre("La course, plus qu’une passion, une méthode.");
        $actualiteCourseEtudes->setContenu("Cumuler les études et le sport n’est pas forcément quelque chose de facile à faire. Mais pas pour cet étudiant qui, en cumulant l’athlétisme et l’IUT, se retrouve à participer aux Jeux-Olympiques et dispose d’une moyenne générale de 18,5 ! Son secret ? Il nous le dévoilera dans l’interview que nous tiendrons la semaine prochaine avec lui ! Alors rendez-vous la semaine prochaine sur le site de Hego Berria pour plus d’informations !");
        $actualiteCourseEtudes->setDateActualisation(new \DateTime("15-01-2017"));
        $actualiteCourseEtudes->setDatePublication(new \DateTime("12-01-2017"));
        $actualiteCourseEtudes->setIcone("58bb0f58e55a1.png");
        
        // On rend l'actualite persistant pour pouvoir y faire référence ensuite
        $manager->persist($actualiteCourseEtudes);
        
         /* ****************************************** */
        /* CREATION INFORMATION 1 Le chômage a disparu */
        /* ******************************************* */
        
        $informationChomage = new Information();
        $informationChomage->setTitre("Le chômage a disparu");
        $informationChomage->setContenu("Non c'est pas vrai");
        $informationChomage->setDateActualisation(new \DateTime("01-04-2017"));
        $informationChomage->setDatePublication(new \DateTime("01-04-2017"));
        
        // On rend l'information persistant pour pouvoir y faire référence ensuite
        $manager->persist($informationChomage);
        
        
        
        
        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        // On déclenche l'enregistrement de tous les stages,formations et entreprises en BD
        $manager->flush();
    }
}