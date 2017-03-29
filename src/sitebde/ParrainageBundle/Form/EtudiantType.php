<?php

namespace sitebde\ParrainageBundle\Form;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EtudiantType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', TextareaType::class, array('required' => false))
                ->add('etudiantMatiereFortes', entityType::class, array('label' => 'Mes matières fortes',
                                                                         'class' => 'sitebdeParrainageBundle:Matiere',
                                                                         'choice_label' => 'libelle',
                                                                         'multiple' => true,
                                                                         'expanded' => true))
                ->add('etudiantMatiereFaibles', entityType::class, array('label' => 'Mes matières faibles',
                                                                          'class' => 'sitebdeParrainageBundle:Matiere',
                                                                          'choice_label' => 'libelle',
                                                                          'multiple' => true,
                                                                          'expanded' => true))
                ->add('loisirsAssocies', entityType::class, array('label' => 'Mes loisirs',
                                                                  'class' => 'sitebdeParrainageBundle:Loisir',
                                                                  'choice_label' => 'libelle',
                                                                  'multiple' => true,
                                                                  'expanded' => true))
                ->add('sportsAssocies', entityType::class, array('label' => 'Mes sports',
                                                                 'class' => 'sitebdeParrainageBundle:Sport',
                                                                 'choice_label' => 'libelle',
                                                                 'multiple' => true,
                                                                 'expanded' => true))
                ->add('liens', collectionType::class, array('entry_type' => LienType::class,
                                                            'allow_add' => true,
                                                            'allow_delete' => true,
                                                            'by_reference' => true,
                                                            'label' => 'Mes liens'));
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $etudiant = $event->getData();
            $photo = $etudiant->getPhoto();
            
            $formulaire = $event->getForm();
            $formulaire->add('imageFile', FileType::class, array('label' => 'Photo', 'required' => false));
        });
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'sitebde\ParrainageBundle\Entity\Etudiant'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sitebde_parrainagebundle_etudiant';
    }

}