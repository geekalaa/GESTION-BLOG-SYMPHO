<?php

namespace Gestion_BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
            ->add('description',TextareaType::class, [
                'attr' => ['rows' => '6'],'attr' =>[ 'cols' => '50']
            ])
            ->add('image',FileType::class,[
                'label' => "Miniature d'article",
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',// 1MB
                        'mimeTypes' => [ //types
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'SVP sélectionner une image JPEG',
                    ]),

                ],
            ])
            ->add('contenu')
            ->add('categorie')
            ->add('tag1')
            ->add('tag2')
            ->add('tag3')
        ->add('Ajouter',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gestion_BlogBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestion_blogbundle_article';
    }


}
