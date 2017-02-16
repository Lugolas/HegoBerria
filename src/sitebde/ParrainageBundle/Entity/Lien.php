<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use sitebde\ParrainageBundle\Entity\Etudiant;

/**
 * Lien
 *
 * @ORM\Table(name="lien")
 * @ORM\Entity(repositoryClass="sitebde\ParrainageBundle\Repository\LienRepository")
 */
class Lien
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
     * @ORM\Column(name="libelle", type="string", length=20)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text")
     */
    private $url;

    /**
     *
     * @ORM\ManyToOne(targetEntity="sitebde\ParrainageBundle\Entity\Etudiant", inversedBy="liens")
     */
    private $etudiant;




    /**
     * Constructor
     */
    public function __construct(\sitebde\ParrainageBundle\Entity\Etudiant $etudiant, $nomSite, $url)
    {
        $this->setEtudiant($etudiant);
        $this->setLibelle($nomSite);
        $this->setUrl($url);
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Lien
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
     * Set url
     *
     * @param string $url
     *
     * @return Lien
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set etudiant
     *
     * @param \sitebde\ParrainageBundle\Entity\Etudiant $etudiant
     *
     * @return Lien
     */
    public function setEtudiant(\sitebde\ParrainageBundle\Entity\Etudiant $etudiant = null)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return \sitebde\ParrainageBundle\Entity\Lien
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }
}
