<?php

namespace sitebde\ParrainageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use sitebde\ParrainageBundle\Entity\Activite;
use sitebde\ParrainageBundle\Entity\Matiere;
use sitebde\ParrainageBundle\Entity\EtudiantLoisir;
use sitebde\ParrainageBundle\Entity\EtudiantSport;
use sitebde\ParrainageBundle\Entity\Loisir;
use sitebde\ParrainageBundle\Entity\Sport;
use sitebde\ParrainageBundle\Entity\Lien;

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
     * @ORM\Column(name="login", type="string", length=50, unique=true)
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
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\EtudiantMatiereForte", mappedBy="etudiant", cascade={"persist", "remove"})
     */
    private $etudiantMatiereFortes;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\EtudiantMatiereFaible", mappedBy="etudiant", cascade={"persist", "remove"})
     */
    private $etudiantMatiereFaibles;


    /**
     *
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\EtudiantLoisir", mappedBy="etudiant", cascade={"persist", "remove"})
     */
    private $etudiantLoisirs;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\EtudiantSport", mappedBy="etudiant", cascade={"persist", "remove"})
     */
    private $etudiantSports;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\DemandeParrainage", mappedBy="etudiantDemandeur", cascade={"persist", "remove"})
     */
    private $demandesFaites;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\DemandeParrainage", mappedBy="etudiantDemande", cascade={"persist", "remove"})
     */
    private $demandesRecues;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="sitebde\ParrainageBundle\Entity\Lien", mappedBy="etudiant", cascade={"persist", "remove"})
     */
    private $liens;







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
        $this->etudiantMatiereFaibles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etudiantMatiereFortes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etudiantLoisirs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etudiantSports = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etudiantsLies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->demandesFaites = new \Doctrine\Common\Collections\ArrayCollection();
        $this->demandesRecues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->liens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add etudiantMatiereForte
     *
     * @param \sitebde\ParrainageBundle\Entity\MatiereForte $etudiantMatiereForte
     *
     * @return Etudiant
     */
    public function addEtudiantMatiereForte(\sitebde\ParrainageBundle\Entity\EtudiantMatiereForte $etudiantMatiereForte)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantMatiereForte[] = $etudiantMatiereForte;

        return $this;
    }

    /**
     * Remove etudiantMatiereForte
     *
     * @param \sitebde\ParrainageBundle\Entity\MatiereForte $etudiantMatiereForte
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
    {       /* Actuellement, cette fonction retourne les matières dans lesquelles un étudiant est fort */
        
        $listeMatieres = new \Doctrine\Common\Collections\ArrayCollection(); 
        
        foreach($this->etudiantMatiereFortes as $etudiantMatiereForte)
        {
            $listeMatieres[] = $etudiantMatiereForte->getMatiere();
        }
        return $listeMatieres;
        
        
        //return $this->etudiantMatiereFortes;
    }

    /**
     * Add etudiantMatiereFaible
     *
     * @param \sitebde\ParrainageBundle\Entity\MatiereFaible $etudiantMatiereFaible
     *
     * @return Etudiant
     */
    public function addEtudiantMatiereFaible(\sitebde\ParrainageBundle\Entity\EtudiantMatiereFaible $etudiantMatiereFaible)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantMatiereFaibles->removeElement($etudiantMatiereFaible);

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
    {       /* Actuellement, cette fonction retourne diretement les matières dans lesquelles un étudiant est faible ! */
    
        $listeMatieres = new \Doctrine\Common\Collections\ArrayCollection(); 
        foreach($this->etudiantMatiereFaibles as $etudiantMatiereFaible)
        {
            $listeMatieres[] = $etudiantMatiereFaible->getMatiere();
        }
        return $listeMatieres;
        
        
        //return $this->etudiantMatiereFaibles;
    }

    /**
     * Add etudiantLoisir
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantLoisir $etudiantLoisir
     *
     * @return Etudiant
     */
    public function addEtudiantLoisir(\sitebde\ParrainageBundle\Entity\EtudiantLoisir $etudiantLoisir)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantLoisirs[] = $loisir;

        return $this;
    }

    /**
     * Remove etudiantLoisir
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantLoisir $etudiantLoisir
     */
    public function removeEtudiantLoisir(\sitebde\ParrainageBundle\Entity\EtudiantLoisir $etudiantLoisir)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantLoisirs->removeElement($etudiantLoisir);
    }

    /**
     * Get loisirsAssocies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLoisirsAssocies() /*Normalement devrait retourner un tableau de LOISIRS (et pas de EtudiantLoisir)*/
    {
        $listeLoisirs = new \Doctrine\Common\Collections\ArrayCollection(); 
        foreach($this->etudiantLoisirs as $etudiantLoisir)
        {
            $listeLoisirs[] = $etudiantLoisir->getLoisir();
        }
        return $listeLoisirs;
    }
    
    /**
     * Get etudiantLoisirs
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLoisirs()
    {
        return $this->etudiantLoisirs;
    }
    
    /**
     * Add etudiantSport
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantSport $etudiantSport
     *
     * @return Etudiant
     */
    public function addEtudiantSport(\sitebde\ParrainageBundle\Entity\EtudiantSport $etudiantSport)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantSports[] = $sport;

        return $this;
    }

    /**
     * Remove etudiantSport
     *
     * @param \sitebde\ParrainageBundle\Entity\EtudiantSport $etudiantSport
     */
    public function removeEtudiantSport(\sitebde\ParrainageBundle\Entity\EtudiantSport $etudiantSport)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->etudiantSports->removeElement($etudiantSport);
    }

    /**
     * Get sportsAssocies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSportsAssocies() /*Normalement devrait retourner un tableau de SPORTS (et pas de EtudiantSport)*/
    {
        $listeSports = new \Doctrine\Common\Collections\ArrayCollection(); 
        foreach($this->etudiantSports as $etudiantSport)
        {
            $listeSports[] = $etudiantSport->getSport();
        }
        return $listeSports;
    }
    
    /**
     * Get etudiantSports
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiantSports()
    {
        return $this->etudiantSports;
    }
    
    
    public function etudiantConforme()
    {
        if ($this->getNumAnnee() == 2)
        {
            if (count($this->getEtudiantsLies()) < 2)
            {
                return true;
            }
        }
        elseif ($this->getNumAnnee() == 1)
        {
            if (count($this->getEtudiantsLies()) == 0)
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
     * Add demandeFaite
     *
     * @param \sitebde\ParrainageBundle\Entity\DemandeParrainage $demandeFaite
     *
     * @return Etudiant
     */
    public function addDemandeFaite(\sitebde\ParrainageBundle\Entity\DemandeParrainage $demandeFaite)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->demandesFaites[] = $demandeFaite;

        return $this;
    }

    /**
     * Remove demandeFaite
     *
     * @param \sitebde\ParrainageBundle\Entity\DemandeParrainage $demandeFaite
     */
    public function removeDemandeFaite(\sitebde\ParrainageBundle\Entity\DemandeParrainage $demandeFaite)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->demandesFaites->removeElement($demandeFaite);
    }

    /**
     * Get demandesFaites
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDemandesFaites()
    {
        return $this->demandesFaites;
    }
    
    

       /**
     * Add demandeRecue
     *
     * @param \sitebde\ParrainageBundle\Entity\DemandeParrainage $demandeRecue
     *
     * @return Etudiant
     */
    public function addDemandeRecue(\sitebde\ParrainageBundle\Entity\DemandeParrainage $demandeRecue)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->demandesRecues[] = $demandeRecue;

        return $this;
    }

    /**
     * Remove demandeRecue
     *
     * @param \sitebde\ParrainageBundle\Entity\DemandeParrainage $demandeRecue
     */
    public function removeDemandeRecue(\sitebde\ParrainageBundle\Entity\DemandeParrainage $demandeRecue)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->demandesRecues->removeElement($demandeRecue);
    }

    /**
     * Get demandesRecues
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDemandesRecues()
    {
        return $this->demandesRecues;
    }




    /**
     * Add lien
     *
     * @param \sitebde\ParrainageBundle\Entity\Lien $lien
     *
     * @return Etudiant
     */
    public function addLien(\sitebde\ParrainageBundle\Entity\Lien $lien)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->liens[] = $lien;

        return $this;
    }

    /**
     * Remove lien
     *
     * @param \sitebde\ParrainageBundle\Entity\Lien $lien
     */
    public function removeLien(\sitebde\ParrainageBundle\Entity\Lien $lien)
    {
        /*******************FONCTION VIDE******************/
        /* Rendue obsolette par les opérations en cascade */
        /**************************************************/
        
        //$this->liens->removeElement($lien);
    }
    
    /**
     * Get Liens
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLiens()
    {
        return $this->liens;
    }



}