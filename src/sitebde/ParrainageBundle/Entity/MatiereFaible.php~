<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use sitebde\ParrainageBundle\Entity\Matiere;

/**
 * MatiereFaible
 *
 * @ORM\Table(name="matiere_faible")
 * @ORM\Entity(repositoryClass="sitebde\ParrainageBundle\Repository\MatiereFaibleRepository")
 */
class MatiereFaible extends Matiere
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
