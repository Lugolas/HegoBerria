<?php

namespace sitebde\ParrainageBundle\Repository;

/**
 * EtudiantRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EtudiantRepository extends \Doctrine\ORM\EntityRepository
{
    // Retourne l'étudiant, ses loisirs, ses sports, ses matières faibles, ses matières fortes et ses liens, tout ça trié selon les catégories
    public function getEtudiantLoisirsEtSports($idEtudiant)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->_em;
        
        // Ecriture de la requête personnalisée
        $requetePerso = $gestionnaireEntites->createQuery('SELECT e, l, el, s, es, emft, mft, emfb, mfb, li
                                                          FROM sitebdeParrainageBundle:Etudiant e
                                                          LEFT JOIN e.etudiantLoisirs el
                                                          LEFT JOIN el.loisir l
                                                          LEFT JOIN e.etudiantSports es
                                                          LEFT JOIN es.sport s
                                                          LEFT JOIN e.etudiantMatiereFortes emft
                                                          LEFT JOIN emft.matiere mft
                                                          LEFT JOIN e.etudiantMatiereFaibles emfb
                                                          LEFT JOIN emfb.matiere mfb
                                                          LEFT JOIN e.liens li
                                                          WHERE e.id = :id
                                                          ORDER BY l.categorie, s.categorie, mft.categorie, mfb.categorie');
        
        $requetePerso->setParameter('id', $idEtudiant);
        
        // Retourner les résultats de l'exécution de la requête
        return $requetePerso->getResult();
    }
    
    public function getAll()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->_em;
        
        // Ecriture de la requête personnalisée
        $requetePerso = $gestionnaireEntites->createQuery('SELECT e, l, el, s, es, emft, mft, emfb, mfb, li
                                                          FROM sitebdeParrainageBundle:Etudiant e
                                                          LEFT JOIN e.etudiantLoisirs el
                                                          LEFT JOIN el.loisir l
                                                          LEFT JOIN e.etudiantSports es
                                                          LEFT JOIN es.sport s
                                                          LEFT JOIN e.etudiantMatiereFortes emft
                                                          LEFT JOIN emft.matiere mft
                                                          LEFT JOIN e.etudiantMatiereFaibles emfb
                                                          LEFT JOIN emfb.matiere mfb
                                                          LEFT JOIN e.liens li
                                                          ORDER BY l.categorie, s.categorie, mft.categorie, mfb.categorie');
        
        // Retourner les résultats de l'exécution de la requête
        return $requetePerso->getResult();
    }
    

    public function getAllParAnnee($anneeVoulue)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->_em;
        
        // Ecriture de la requête personnalisée
        $requetePerso = $gestionnaireEntites->createQuery('SELECT e, l, el, s, es, emft, mft, emfb, mfb, li
                                                          FROM sitebdeParrainageBundle:Etudiant e
                                                          LEFT JOIN e.etudiantLoisirs el
                                                          LEFT JOIN el.loisir l
                                                          LEFT JOIN e.etudiantSports es
                                                          LEFT JOIN es.sport s
                                                          LEFT JOIN e.etudiantMatiereFortes emft
                                                          LEFT JOIN emft.matiere mft
                                                          LEFT JOIN e.etudiantMatiereFaibles emfb
                                                          LEFT JOIN emfb.matiere mfb
                                                          LEFT JOIN e.liens li
                                                          WHERE e.numAnnee = :annee
                                                          ORDER BY l.categorie, s.categorie, mft.categorie, mfb.categorie');
        
        $requetePerso->setParameter('annee', $anneeVoulue);
        
        // Retourner les résultats de l'exécution de la requête
        return $requetePerso->getResult();
    }
    
    // Retourne les demandes reçues et faites par un étudiant donné
    public function getDemandesParrainage($idEtudiant)
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->_em;
        
        // Ecriture de la requête personnalisée
        $requetePerso = $gestionnaireEntites->createQuery('SELECT e, dr, edr, df, edf
                                                          FROM sitebdeParrainageBundle:Etudiant e
                                                          LEFT JOIN e.demandesRecues dr
                                                          LEFT JOIN dr.etudiantDemandeur edr
                                                          LEFT JOIN e.demandesFaites df
                                                          LEFT JOIN df.etudiantDemande edf
                                                          WHERE e.id = :id
                                                          ORDER BY df.estAcceptee DESC, dr.estAcceptee DESC');
        
        $requetePerso->setParameter('id', $idEtudiant);
        
        // Retourner les résultats de l'exécution de la requête
        return $requetePerso->getResult();
    }
    
    public function getMembresBDE()
    {
        // Récupérer le gestionnaire d'entités
        $gestionnaireEntites = $this->_em;
        
        // Ecriture de la requête personnalisée
        $requetePerso = $gestionnaireEntites->createQuery('SELECT e
                                                          FROM sitebdeParrainageBundle:Etudiant e
                                                          WHERE e.estBDE = 1 OR e.estAdmin = 1');
        
        // Retourner les résultats de l'exécution de la requête
        return $requetePerso->getResult();
    }
}
