<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtudiantSport
 *
 * @ORM\Table(name="etudiant_sport")
 * @ORM\Entity(repositoryClass="sitebde\ParrainageBundle\Repository\EtudiantSportRepository")
 */
class EtudiantSport
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
     * @ORM\ManyToOne(targetEntity="sitebde\ParrainageBundle\Entity\Sport", inversedBy="etudiants")
     */
    private $sport;

    /**
     *
     * @ORM\ManyToOne(targetEntity="sitebde\ParrainageBundle\Entity\Etudiant", inversedBy="sports")
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
     * @return EtudiantSport
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
     * Set sport
     *
     * @param \sitebde\ParrainageBundle\Entity\Sport $sport
     *
     * @return EtudiantSport
     */
    public function setSport(\sitebde\ParrainageBundle\Entity\Sport $sport = null)
    {
        $sport->addEtudiant($this);
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get sport
     *
     * @return \sitebde\ParrainageBundle\Entity\Sport
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Set etudiant
     *
     * @param \sitebde\ParrainageBundle\Entity\Etudiant $etudiant
     *
     * @return EtudiantSport
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