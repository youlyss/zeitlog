<?php

namespace App\Form;

use App\Entity\Worktime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorktimeType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startTime', \DateTime::class, ['format'=>'Y-m-d h:i:s'])
            ->add('endTime', \DateTime::class,['format'=>'Y-m-d h:i:s']);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Worktime::class,
            'csrf_protection' => false,
        ]);
    }


}