<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtudiantMatiereForte
 *
 * @ORM\Table(name="etudiant_matiere_forte")
 * @ORM\Entity(repositoryClass="sitebde\ParrainageBundle\Repository\EtudiantMatiereForteRepository")
 */
class EtudiantMatiereForte
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
     *
     * @ORM\ManyToOne(targetEntity="sitebde\ParrainageBundle\Entity\Etudiant", inversedBy="etudiantMatiereFortes")
     */
    private $etudiant;
    

    /**
     *
     * @ORM\ManyToOne(targetEntity="sitebde\ParrainageBundle\Entity\Matiere", inversedBy="etudiantMatiereFortes")
     */
    private $matiere;


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
    public function __construct(\sitebde\ParrainageBundle\Entity\Etudiant $etudiant, \sitebde\ParrainageBundle\Entity\Matiere $matiere)
    {
        $this->setEtudiant($etudiant);
        $this->setMatiere($matiere);
    }



    /**
     * Set etudiant
     *
     * @param \sitebde\ParrainageBundle\Entity\Etudiant $etudiant
     *
     * @return EtudiantMatiereForte
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

    /**
     * Set matiere
     *
     * @param \sitebde\ParrainageBundle\Entity\Matiere $matiere
     *
     * @return EtudiantMatiereForte
     */
    public function setMatiere(\sitebde\ParrainageBundle\Entity\Matiere $matiere = null)
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return \sitebde\ParrainageBundle\Entity\Matiere
     */
    public function getMatiere()
    {
        return $this->matiere;
    }
}
