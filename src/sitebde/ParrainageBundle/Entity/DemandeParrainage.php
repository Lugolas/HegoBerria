<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeParrainage
 *
 * @ORM\Table(name="demande_parrainage")
 * @ORM\Entity(repositoryClass="sitebde\ParrainageBundle\Repository\DemandeParrainageRepository")
 */
class DemandeParrainage
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
     * @var bool
     *
     * @ORM\Column(name="estAcceptee", type="boolean")
     */
    private $estAcceptee;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="sitebde\ParrainageBundle\Entity\Etudiant", inversedBy="demandesFaites")
     */
    private $etudiantDemandeur;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="sitebde\ParrainageBundle\Entity\Etudiant", inversedBy="demandesRecues")
     */
    private $etudiantDemande;


    /**
     * Constructor
     */
    public function __construct(\sitebde\ParrainageBundle\Entity\Etudiant $etudiantDemandeur, \sitebde\ParrainageBundle\Entity\Etudiant $etudiantDemande, $estValidee = false)
    {
        $this->setEtudiantDemandeur($etudiantDemandeur);
        $this->setEtudiantDemande($etudiantDemande);
        $this->setEstAcceptee($estValidee);
    }


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
     * Set estAcceptee
     *
     * @param boolean $estAcceptee
     *
     * @return DemandeParrainage
     */
    public function setEstAcceptee($estAcceptee)
    {
        $this->estAcceptee = $estAcceptee;

        return $this;
    }

    /**
     * Get estAcceptee
     *
     * @return bool
     */
    public function getEstAcceptee()
    {
        return $this->estAcceptee;
    }

    /**
     * Set etudiantDemandeur
     *
     * @param \sitebde\ParrainageBundle\Entity\Etudiant $etudiantDemandeur
     *
     * @return DemandeParrainage
     */
    public function setEtudiantDemandeur(\sitebde\ParrainageBundle\Entity\Etudiant $etudiantDemandeur = null)
    {
        $this->etudiantDemandeur = $etudiantDemandeur;

        return $this;
    }

    /**
     * Get etudiantDemandeur
     *
     * @return \sitebde\ParrainageBundle\Entity\Etudiant
     */
    public function getEtudiantDemandeur()
    {
        return $this->etudiantDemandeur;
    }

    /**
     * Set etudiantDemande
     *
     * @param \sitebde\ParrainageBundle\Entity\Etudiant $etudiantDemande
     *
     * @return DemandeParrainage
     */
    public function setEtudiantDemande(\sitebde\ParrainageBundle\Entity\Etudiant $etudiantDemande = null)
    {
        $this->etudiantDemande = $etudiantDemande;

        return $this;
    }

    /**
     * Get etudiantDemande
     *
     * @return \sitebde\ParrainageBundle\Entity\Etudiant
     */
    public function getEtudiantDemande()
    {
        return $this->etudiantDemande;
    }
}
