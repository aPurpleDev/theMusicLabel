<?php

namespace App\Form;


use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubType extends AbstractType
{

    private $artist;
    /**
     * SubType constructor.
     */
    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sub', SubmitType::class, ['label' => 'Sub'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}