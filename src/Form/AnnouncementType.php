<?php

namespace App\Form;

use App\Entity\Announcement;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => 'Titre de l\'annonce',
                'attr' => array(
                    'placeholder' => 'Entrez un titre...'
                )
            ))
            ->add('img1', FileType::class, array(
                'label' => 'Ajouter une image 1'
            ))
            ->add('img2', FileType::class, array(
                'label' => 'Ajouter une image 2'
            ))
            ->add('img3', FileType::class, array(
                'label' => 'Ajouter une image 3'
            ))
            ->add('status', ChoiceType::class, array(
                'label' => 'État de l\'objet',
                'choices' => array(
                    'Neuf' => 'Neuf',
                    'Très bon état' => 'Très bon état',
                    'Bon état' => 'Bon état',
                    'Endommagé (Pour pièces)' => 'Endommagé (Pour pièces)'
                )
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description et caractéristque du produit'
            ))
            ->add('category', EntityType::class, array(
                'label' => 'Catégorie de l\'objet à vendre',
                'class' => Category::class,
                'choice_label' => 'name'
            ))
            ->add('price', MoneyType::class, array(
                'label' => 'Prix de vente',
                'attr' => array(
                    'placeholder' => 'Votre prix de vente ...'
                )
            ))
            ->add('username', null, array(
                'label' => 'Pseudo affiché pour la vente',
                'attr' => array(
                    'placeholder' => 'Entrez votre pseudo...'
                )
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email de contact',
                'attr' => array(
                    'placeholder' => 'aze@aze.fr ...'
                )
            ))
            ->add('phone', null, array(
                'label' => 'Numéro de téléphone',
                'attr' => array(
                    'placeholder' => '0123456789'
                )
            ))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
        ]);
    }
}