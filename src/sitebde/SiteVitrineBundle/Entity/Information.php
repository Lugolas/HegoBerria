<?php

namespace sitebde\SiteVitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use sitebde\SiteVitrineBundle\Entity\Publication;

/**
 * Information
 *
 * @ORM\Table(name="information")
 * @ORM\Entity(repositoryClass="sitebde\SiteVitrineBundle\Repository\InformationRepository")
 */
class Information extends Publication
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
