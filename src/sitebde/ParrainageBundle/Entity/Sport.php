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
    protected $etudiants;

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
     * Constructor
     */
    public function __construct()
    {
        $this->etudiants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add etudiant
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantSport $etudiant
     *
     * @return Sport
     */
    public function addEtudiant(\sitebde\ParrainageBundle\Entity\EtudiantSport $etudiant)
    {
        //$this->etudiants[] = $etudiant;

        return $this;
    }

    /**
     * Remove etudiant
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantSport $etudiant
     */
    public function removeEtudiant(\sitebde\ParrainageBundle\Entity\EtudiantSport $etudiant)
    {
        $this->etudiants->removeElement($etudiant);
    }

    /**
     * Get etudiants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiants() /*Normalement devrait retourner un tableau d'ETUDIANT (et pas de EtudiantSport)*/
    {
        $listeEtudiants = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($this->etudiants as $etudiantSport)
        {
            $listeEtudiants[] = $etudiantSport->getEtudiant();
        }
        return $listeEtudiants;
    }
}
