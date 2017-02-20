<?php

namespace sitebde\SiteVitrineBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EvenementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', textType::class)
            ->add('contenu', textareaType::class, array('label' => 'Description'))
            ->add('dateEvenement', dateType::class, array('label' => 'Date', 'format' => 'dd/MM/yyyy'))
            ->add('icone', FileType::class, array('data_class' => null))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'sitebde\SiteVitrineBundle\Entity\Evenement'
        ));
    }
}
