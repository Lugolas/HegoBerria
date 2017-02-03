<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use sitebde\ParrainageBundle\Entity\Matiere;

/**
 * MatiereForte
 *
 * @ORM\Table(name="matiere_forte")
 * @ORM\Entity(repositoryClass="sitebde\ParrainageBundle\Repository\MatiereForteRepository")
 */
class MatiereForte extends Matiere
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
     * @ORM\ManyToMany(targetEntity="sitebde\ParrainageBundle\Entity\Etudiant", mappedBy="matieresFortes")
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
     * @param \sitebde\ParrainageBundle\Entity\Etudiant $etudiant
     *
     * @return MatiereForte
     */
    public function addEtudiant(\sitebde\ParrainageBundle\Entity\Etudiant $etudiant)
    {
        $this->etudiants[] = $etudiant;

        return $this;
    }

    /**
     * Remove etudiant
     *
     * @param \sitebde\ParrainageBundle\Entity\Etudiant $etudiant
     */
    public function removeEtudiant(\sitebde\ParrainageBundle\Entity\Etudiant $etudiant)
    {
        $this->etudiants->removeElement($etudiant);
    }

    /**
     * Get etudiants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiants()
    {
        return $this->etudiants;
    }
}
