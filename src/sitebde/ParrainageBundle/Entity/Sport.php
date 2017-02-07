<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use sitebde\ParrainageBundle\Entity\Activite;

/**
 * Sport
 *
 * @ORM\Table(name="sport")
 * @ORM\Entity(repositoryClass="sitebde\ParrainageBundle\Repository\SportRepository")
 */
class Sport extends Activite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\EtudiantSport", mappedBy="sport", cascade={"persist", "remove"})
     */
    protected $etudiantSports;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get etudiants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiants() /*Normalement devrait retourner un tableau d'ETUDIANT (et pas de EtudiantSport)*/
    {
        $listeEtudiants = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($this->etudiantSports as $etudiantSport)
        {
            $listeEtudiants[] = $etudiantSport->getEtudiant();
        }
        return $listeEtudiants;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->etudiantSports = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add etudiantSport
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantSport $etudiantSport
     *
     * @return Sport
     */
    public function addEtudiantSport(\sitebde\ParrainageBundle\Entity\EtudiantSport $etudiantSport)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantSports[] = $etudiantSport;

        return $this;
    }

    /**
     * Remove etudiantSport
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantSport $etudiantSport
     */
    public function removeEtudiantSport(\sitebde\ParrainageBundle\Entity\EtudiantSport $etudiantSport)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantSports->removeElement($etudiantSport);
    }

    /**
     * Get etudiantSports
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiantSports()
    {
        return $this->etudiantSports;
    }
}
