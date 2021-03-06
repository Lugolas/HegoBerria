<?php

namespace sitebde\SiteVitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use sitebde\SiteVitrineBundle\Entity\Article;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Actualite
 *
 * @ORM\Table(name="actualite")
 * @ORM\Entity(repositoryClass="sitebde\SiteVitrineBundle\Repository\ActualiteRepository")
 */
class Actualite extends Article
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
