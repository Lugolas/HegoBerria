<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table(name="matiere")
 * @ORM\Entity(repositoryClass="sitebde\ParrainageBundle\Repository\MatiereRepository")
 */
class Matiere
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=100)
     */
    protected $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=100)
     */
    protected $categorie;

    /**
     *
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\EtudiantMatiereForte", mappedBy="matiere", cascade={"persist", "remove"})
     */
    private $etudiantMatiereFortes;

    /**
     *
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\EtudiantMatiereFaible", mappedBy="matiere", cascade={"persist", "remove"})
     */
    private $etudiantMatiereFaibles;

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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Matiere
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     *
     * @return Matiere
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->etudiantMatiereFortes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etudiantMatiereFaibles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add etudiantMatiereForte
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantMatiereForte $etudiantMatiereForte
     *
     * @return Matiere
     */
    public function addEtudiantMatiereForte(\sitebde\ParrainageBundle\Entity\EtudiantMatiereForte $etudiantMatiereForte)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantMatiereFortes[] = $etudiantMatiereForte;

        return $this;
    }

    /**
     * Remove etudiantMatiereForte
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantMatiereForte $etudiantMatiereForte
     */
    public function removeEtudiantMatiereForte(\sitebde\ParrainageBundle\Entity\EtudiantMatiereForte $etudiantMatiereForte)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantMatiereFortes->removeElement($etudiantMatiereForte);
    }

    /**
     * Get etudiantMatiereFortes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiantMatiereFortes()
    {
        return $this->etudiantMatiereFortes;
    }

    /**
     * Add etudiantMatiereFaible
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantMatiereFaible $etudiantMatiereFaible
     *
     * @return Matiere
     */
    public function addEtudiantMatiereFaible(\sitebde\ParrainageBundle\Entity\EtudiantMatiereFaible $etudiantMatiereFaible)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantMatiereFaibles[] = $etudiantMatiereFaible;

        return $this;
    }

    /**
     * Remove etudiantMatiereFaible
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantMatiereFaible $etudiantMatiereFaible
     */
    public function removeEtudiantMatiereFaible(\sitebde\ParrainageBundle\Entity\EtudiantMatiereFaible $etudiantMatiereFaible)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantMatiereFaibles->removeElement($etudiantMatiereFaible);
    }

    /**
     * Get etudiantMatiereFaibles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiantMatiereFaibles()
    {
        return $this->etudiantMatiereFaibles;
    }
}
