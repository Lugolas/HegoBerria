<?php

namespace sitebde\SiteVitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\MappedSuperclass()
 */
class Publication
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
     * @ORM\Column(name="titre", type="string", length=100)
     */
    protected $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    protected $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateActualisation", type="datetime")
     */
    protected $dateActualisation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePublication", type="datetime")
     */
    protected $datePublication;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return Publication
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Publication
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set dateActualisation
     *
     * @param \DateTime $dateActualisation
     *
     * @return Publication
     */
    public function setDateActualisation($dateActualisation)
    {
        $this->dateActualisation = $dateActualisation;

        return $this;
    }

    /**
     * Get dateActualisation
     *
     * @return \DateTime
     */
    public function getDateActualisation()
    {
        return $this->dateActualisation;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Publication
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }
}
