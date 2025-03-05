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
                    'Conahcyt'=> 'Conahcyt',
                    'Ingresos extraordinarios'=> 'Ingresos extraordinarios',
                    'PAPIIT'=> 'PAPIIT',
                    'PAPIME'=> 'PAPIME'
                ],
                'placeholder' => 'Seleccionar',
            ])
            ->add('solicitante')
            ->add('proyecto')
            ->add('acta',null,[
                'required'=> false,
            ])
            ->add(
                'motivo',
                ChoiceType::class,
                [
                    'choices' => [
                        'Asistencia' => 'Asistencia',
                        'Participación' => 'Participación',
                    ],
                    'expanded' => true,
                    'multiple' => true,
                    'label'=>'Motivo',

                ]
            )
            ->add('tipoActividad', ChoiceType::class, [
                'choices'  => [
                    'Asesoría Tesis'=>'Asesoría Tesis',
                    'Coloquio'=> 'Coloquio',
                    'Conferencia'=> 'Conferencia',
                    'Congreso'=> 'Congreso',
                    'Curso'=> 'Curso',
                    'Distinción Académica'=> 'Distinción Académica',
                    'Feria'=>'Feria',
                    'Investigación'=>'Investigación',
                    'Jornadas'=>'Jornadas',
                    'Mesa redonda'=>'Mesa redonda',
                    'Reunión de trabajo'=>'Reunión de trabajo',
                    'Seminario'=>'Seminario',
                    'Sinodal'=>'Sinodal',
                    'Taller'=>'Taller',

                ],
                'placeholder' => 'Seleccionar',
            ])
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
            ->add('responsable')
            ->add('institucion')
            ->add('lugar')
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
