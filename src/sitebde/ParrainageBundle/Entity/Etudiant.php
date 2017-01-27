<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use sitebde\ParrainageBundle\Entity\Activite;
use sitebde\ParrainageBundle\Entity\Matiere;
use sitebde\ParrainageBundle\Entity\EtudiantLoisir;
use sitebde\ParrainageBundle\Entity\EtudiantSport;
use sitebde\ParrainageBundle\Entity\Loisir;
use sitebde\ParrainageBundle\Entity\Sport;

/**
 * Etudiant
 *
 * @ORM\Table(name="etudiant")
 * @ORM\Entity(repositoryClass="sitebde\ParrainageBundle\Repository\EtudiantRepository")
 */
class Etudiant
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
     * @ORM\Column(name="login", type="string", length=20, unique=true)
     */
    private $login;

    /**
     * @var bool
     *
     * @ORM\Column(name="estBDE", type="boolean")
     */
    private $estBDE;

    /**
     * @var bool
     *
     * @ORM\Column(name="estAdmin", type="boolean")
     */
    private $estAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1)
     */
    private $sexe;

    /**
     * @var int
     *
     * @ORM\Column(name="numAnnee", type="integer")
     */
    private $numAnnee;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=100, nullable=true)
     */
    private $photo;
    

    
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="sitebde\ParrainageBundle\Entity\MatiereForte")
     */
    private $matieresFortes;
    
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="sitebde\ParrainageBundle\Entity\MatiereFaible")
     */
    private $matieresFaibles;


    /**
     *
     * @ORM\ManyToMany(targetEntity="sitebde\ParrainageBundle\Entity\Etudiant")
     */
    private $etudiantsLies;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\EtudiantSport", mappedBy="etudiant")
     */
    private $sports;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\EtudiantLoisir", mappedBy="etudiant")
     */
    private $loisirs;


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
     * Set login
     *
     * @param string $login
     *
     * @return Etudiant
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set estBDE
     *
     * @param boolean $estBDE
     *
     * @return Etudiant
     */
    public function setEstBDE($estBDE)
    {
        $this->estBDE = $estBDE;

        return $this;
    }

    /**
     * Get estBDE
     *
     * @return bool
     */
    public function getEstBDE()
    {
        return $this->estBDE;
    }

    /**
     * Set estAdmin
     *
     * @param boolean $estAdmin
     *
     * @return Etudiant
     */
    public function setEstAdmin($estAdmin)
    {
        $this->estAdmin = $estAdmin;

        return $this;
    }

    /**
     * Get estAdmin
     *
     * @return bool
     */
    public function getEstAdmin()
    {
        return $this->estAdmin;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Etudiant
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Etudiant
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Etudiant
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set numAnnee
     *
     * @param integer $numAnnee
     *
     * @return Etudiant
     */
    public function setNumAnnee($numAnnee)
    {
        $this->numAnnee = $numAnnee;

        return $this;
    }

    /**
     * Get numAnnee
     *
     * @return int
     */
    public function getNumAnnee()
    {
        return $this->numAnnee;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Etudiant
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Etudiant
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->loisirs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sports = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matieresFortes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etudiants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matieresFaibles = new \Doctrine\Common\Collections\ArrayCollection();
    }

   

    /**
     * Add etudiant
     *
     * @param \sitebde\ParrainageBundle\Entity\Etudiant $etudiant
     *
     * @return Etudiant
     */
    public function addEtudiant(\sitebde\ParrainageBundle\Entity\Etudiant $etudiant)
    {
        if(etudiantConforme())
        {
            $this->etudiantsLies[] = $etudiant;
            return $this;
        }
        return -1;
    }

    /**
     * Remove etudiantLie
     *
     * @param \sitebde\ParrainageBundle\Entity\Etudiant $etudiant
     */
    public function removeEtudiant(\sitebde\ParrainageBundle\Entity\Etudiant $etudiant)
    {
        $this->etudiantsLies->removeElement($etudiant);
    }

    /**
     * Get etudiantsLies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiantsLies()
    {
        return $this->etudiantsLies;
    }
    
    
    
    
    
    public function etudiantConforme()
    {
        if ($this->getNumAnnee() == 2)
        {
            if (count($this->getEtudiants()) < 2)
            {
                return true;
            }
        }
        elseif ($this->getNumAnnee() == 1)
        {
            if (count($this->getEtudiants()) == 0)
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }




    /**
     * Add matiereForte
     *
     * @param \sitebde\ParrainageBundle\Entity\MatiereForte $matieresForte
     *
     * @return Etudiant
     */
    public function addMatiereForte(\sitebde\ParrainageBundle\Entity\MatiereForte $matiereForte)
    {
        $this->matieresFortes[] = $matiereForte;

        return $this;
    }

    /**
     * Remove matiereForte
     *
     * @param \sitebde\ParrainageBundle\Entity\MatiereForte $matiereForte
     */
    public function removeMatiereForte(\sitebde\ParrainageBundle\Entity\MatiereForte $matiereForte)
    {
        $this->matieresFortes->removeElement($matiereForte);
    }

    /**
     * Get matieresFortes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatieresFortes()
    {
        return $this->matieresFortes;
    }

    /**
     * Add matiereFaible
     *
     * @param \sitebde\ParrainageBundle\Entity\MatiereFaible $matiereFaible
     *
     * @return Etudiant
     */
    public function addMatiereFaible(\sitebde\ParrainageBundle\Entity\MatiereFaible $matiereFaible)
    {
        $this->matieresFaibles[] = $matiereFaible;

        return $this;
    }

    /**
     * Remove matiereFaible
     *
     * @param \sitebde\ParrainageBundle\Entity\MatiereFaible $matiereFaible
     */
    public function removeMatiereFaible(\sitebde\ParrainageBundle\Entity\MatiereFaible $matiereFaible)
    {
        $this->matieresFaibles->removeElement($matiereFaible);
    }

    /**
     * Get matieresFaibles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatieresFaibles()
    {
        return $this->matieresFaibles;
    }

  




    

    
   

   

    /**
     * Add sport
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantSport $sport
     *
     * @return Etudiant
     */
    public function addSport(\sitebde\ParrainageBundle\Entity\EtudiantSport $etudiantSport, \sitebde\ParrainageBundle\Entity\Sport $sport, $commentaire = null)
    {
        $etudiantSport->setEtudiant($this);
        $etudiantSport->setSport($sport);
        $etudiantSport->setCommentaire($commentaire);
        $this->sports[] = $sport;

        return $this;
    }

    /**
     * Remove sport
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantSport $sport
     */
    public function removeSport(\sitebde\ParrainageBundle\Entity\EtudiantSport $sport)
    {
        $sport->getSport()->removeEtudiant($sport);
        $this->sports->removeElement($sport);
    }

    /**
     * Get sports
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSports()
    {
        return $this->sports;
    }

    /**
     * Add loisir
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantLoisir $loisir
     *
     * @return Etudiant
     */
    public function addLoisir(\sitebde\ParrainageBundle\Entity\EtudiantLoisir $etudiantLoisir, \sitebde\ParrainageBundle\Entity\Loisir $loisir, $commentaire  = null)
    {
        $etudiantLoisir->setEtudiant($this);
        $etudiantLoisir->setCommentaire($commentaire);
        $etudiantLoisir->setLoisir($loisir);
        $this->loisirs[] = $loisir;

        return $this;
    }

    /**
     * Remove loisir
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantLoisir $loisir
     */
    public function removeLoisir(\sitebde\ParrainageBundle\Entity\EtudiantLoisir $loisir)
    {
        $loisir->getLoisir()->removeEtudiant($loisir);
        $this->loisirs->removeElement($loisir);
    }

    /**
     * Get loisirs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLoisirs()
    {
        return $this->loisirs;
    }
}
