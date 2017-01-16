<?php

namespace sitebde\SiteVitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use sitebde\SiteVitrineBundle\Entity\Article;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="sitebde\SiteVitrineBundle\Repository\EvenementRepository")
 */
class Evenement extends Article
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateEvenement", type="datetime")
     */
    protected $dateEvenement;


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
     * Set dateEvenement
     *
     * @param \DateTime $dateEvenement
     *
     * @return Evenement
     */
    public function setDateEvenement($dateEvenement)
    {
        $this->dateEvenement = $dateEvenement;

        return $this;
    }

    /**
     * Get dateEvenement
     *
     * @return \DateTime
     */
    public function getDateEvenement()
    {
        return $this->dateEvenement;
    }
}
