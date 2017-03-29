<?php

namespace AppBundle\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    
    public function mentionsLegalesAction()
    {
        return $this->render('default/mentionsLegales.html.twig');
    }
    
    public function contactAction()
    {
        /* On construit un tableau dans lequel les données du formulaire 
           seront recueillies */
        $tabDonneesDuMessage = array(); 
    
        // Création du formulaire de contact
           $formulaireContact = $this->createFormBuilder($tabDonneesDuMessage)
                ->add('nom', textType::class)
                ->add('emailExpediteur', emailType::class, array('label' => 'Email'))
                ->add('contenuMessage', textAreaType::class, array('label' => 'Message'))
                ->getForm();         
         
        /* On envoie la représentation graphique du formulaire à la vue 
           chargée de l'afficher */
        return $this->render('default/contact.html.twig',
               array('formulaireContact' => $formulaireContact->createView()));
    }
    
    public function envoyerMailAction()
    {
        return $this->redirect($this->generateUrl('sitebde_siteVitrine_accueil'));
    }
}
    


