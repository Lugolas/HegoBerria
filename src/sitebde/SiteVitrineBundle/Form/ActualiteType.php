<?php

namespace sitebde\SiteVitrineBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Form\Type\VichImageType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ActualiteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', textType::class)
            ->add('contenu', textAreaType::class, array('label' => 'Description'))
            ->add('imageFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true, // not mandatory, default is true
            'download_link' => true, // not mandatory, default is true
        ]);
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $actualite = $event->getData();
            $formulaire = $event->getForm();
    
            // Actualité vide = création
            if (!$actualite || null === $actualite->getId()) {
                $formulaire->add('imageFile', FileType::class, array('label' => 'Icône'));
            }
            // Sinon, modification
            else {
                $icone = $actualite->getIcone();
                $formulaire->add('imageFile', FileType::class, array('label' => 'Icône', 'required' => false, 'empty_data' => new File($icone)));
            }
        });
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'sitebde\SiteVitrineBundle\Entity\Actualite'
        ));
    }
}
