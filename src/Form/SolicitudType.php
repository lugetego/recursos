<?php

namespace App\Form;

use App\Entity\Solicitud;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolicitudType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha',DateType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
            ])
            ->add('tipo', ChoiceType::class, [
                'choices'  => [
                    'Viáticos'=> 'Viáticos',
                    'Visitante' => 'Visitante',
                    'Trabajo de campo' => 'Trabajo de campo',
                ],
                'placeholder' => 'Seleccionar',
            ])
            ->add('fuente', ChoiceType::class, [
                'choices'  => [
                    'CCM'=> 'CCM',
                    'Conacyt'=> 'Conacyt',
                    'Ingresos extraordinarios'=> 'Ingresos extraordinarios',
                    'PAPIIT'=> 'PAPIIT',
                    'PAPIME'=> 'PAPIME'
                ],
                'placeholder' => 'Seleccionar',
            ])
            ->add('nombre')
            ->add('proyecto',null,[
                'required'=> false,
            ])
            ->add('acta',null,[
                'required'=> false,
            ])
            ->add(
                'nacional',
                ChoiceType::class,
                [
                    'choices' => [
                        'Nacional' => true,
                        'Internacional' => false,
                    ],
                    'expanded' => true,
                    'label'=>'Ámbito de la solicitud',

                ]
            )
            ->add('importe')
            ->add('inicio',DateType::class, [
                'widget' => 'single_text',
                'required'=> false,
                'data' => new \DateTime(),
            ])
            ->add('fin',DateType::class, [
                'widget' => 'single_text',
                'required'=> false,
                'data' => new \DateTime(),

            ])
            ->add('participante')
            ->add('lugar')
            ->add('motivo')
            ->add('gasolina')
            ->add('peaje')
            ->add('hospedaje')
            ->add('alimentos')
            ->add('transporte')
        ;


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Solicitud::class,
        ]);
    }
}
