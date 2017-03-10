<?php

namespace sitebde\ParrainageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;

class EtudiantType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', TextareaType::class)
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
                                                                 'expanded' => true));
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $etudiant = $event->getData();
            $formulaire = $event->getForm();
    
            $photo = $etudiant->getPhoto();
            $formulaire->add('imageFile', FileType::class, array('label' => 'Photo', 'required' => false, 'empty_data' => new File($photo)));
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
