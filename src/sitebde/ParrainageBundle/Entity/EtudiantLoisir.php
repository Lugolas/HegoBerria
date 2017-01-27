<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtudiantLoisir
 *
 * @ORM\Table(name="etudiant_loisir")
 * @ORM\Entity(repositoryClass="sitebde\ParrainageBundle\Repository\EtudiantLoisirRepository")
 */
class EtudiantLoisir
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="sitebde\ParrainageBundle\Entity\Loisir", inversedBy="etudiants")
     */
    private $loisir;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="sitebde\ParrainageBundle\Entity\Etudiant", inversedBy="loisirs")
     */
    private $etudiant;


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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return EtudiantLoisir
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }


    /**
     * Constructor
     */
    public function __construct()
    {

    }

   

    /**
     * Set loisir
     *
     * @param \sitebde\ParrainageBundle\Entity\Loisir $loisir
     *
     * @return EtudiantLoisir
     */
    public function setLoisir(\sitebde\ParrainageBundle\Entity\Loisir $loisir = null)
    {
        $loisir->addEtudiant($this);
        $this->loisir = $loisir;

        return $this;
    }

    /**
     * Get loisir
     *
     * @return \sitebde\ParrainageBundle\Entity\Loisir
     */
    public function getLoisir()
    {
        return $this->loisir;
    }

    /**
     * Set etudiant
     *
     * @param \sitebde\ParrainageBundle\Entity\Etudiant $etudiant
     *
     * @return EtudiantLoisir
     */
    public function setEtudiant(\sitebde\ParrainageBundle\Entity\Etudiant $etudiant = null)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return \sitebde\ParrainageBundle\Entity\Etudiant
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }
}
