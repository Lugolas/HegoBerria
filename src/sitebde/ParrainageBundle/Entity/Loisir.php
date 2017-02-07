<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use sitebde\ParrainageBundle\Entity\Activite;

/**
 * Loisir
 *
 * @ORM\Table(name="loisir")
 * @ORM\Entity(repositoryClass="sitebde\ParrainageBundle\Repository\LoisirRepository")
 */
class Loisir extends Activite
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
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\EtudiantLoisir", mappedBy="loisir", cascade={"persist", "remove"})
     */
    protected $etudiantLoisirs;

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
    public function getEtudiants() /*Normalement devrait retourner un tableau d'ETUDIANT (et pas de EtudiantLoisir)*/
    {
        $listeEtudiants = new \Doctrine\Common\Collections\ArrayCollection(); 
        foreach($this->etudiantLoisirs as $etudiantLoisir)
        {
            $listeEtudiants[] = $etudiantLoisir->getEtudiant();
        }
        return $listeEtudiants;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->etudiantLoisirs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add etudiantLoisir
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantLoisir $etudiantLoisir
     *
     * @return Loisir
     */
    public function addEtudiantLoisir(\sitebde\ParrainageBundle\Entity\EtudiantLoisir $etudiantLoisir)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantLoisirs[] = $etudiantLoisir;

        return $this;
    }

    /**
     * Remove etudiantLoisir
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantLoisir $etudiantLoisir
     */
    public function removeEtudiantLoisir(\sitebde\ParrainageBundle\Entity\EtudiantLoisir $etudiantLoisir)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantLoisirs->removeElement($etudiantLoisir);
    }

    /**
     * Get etudiantLoisirs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiantLoisirs()
    {
        return $this->etudiantLoisirs;
    }
}
