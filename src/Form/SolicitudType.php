<?php

namespace App\Form;

use App\Entity\Solicitud;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class SolicitudType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha',DateType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'required' => true,

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
            ->add('anfitrion')
            ->add('responsable', TextType::class, [
                'required' => false,  // Makes the field required
                'label' => 'Persona responsable del proyecto', ]) // Optional: Add a label if you need one
            ->add('tutor')

            ->add('inicio',DateType::class, [
                'widget' => 'single_text',
              //  'data' => new \DateTime(),
            ])
            ->add('fin',DateType::class, [
                'widget' => 'single_text',
                //  'data' => new \DateTime(),
                'required'=> true,
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
                    'required' => true,
                    'constraints' => [
                        new Assert\Count(['min' => 1, 'minMessage' => 'Seleccionar al menos una opción.']),
                    ]

                ]
            )
            ->add('institucion')
            ->add('lugar')
            ->add('mail', RepeatedType::class, [
                'invalid_message' => 'Los correos no son iguales',
                'first_options'  => ['label' => 'Correo'],
                'second_options' => ['label' => 'Confirma correo']])


            ->add('tipoActividad', ChoiceType::class, [
                'choices'  => [
                    'Asesoría'=>'Asesoría',
                    'Coloquio'=>'Coloquio',
                    'Conferencia'=> 'Conferencia',
                    'Congreso'=> 'Congreso',
                    'Curso'=> 'Curso',
                    'Feria'=> 'Feria',
                    'Jornada'=> 'Jornada',
                    'Póster'=>'Póster',
                    'Seminario'=> 'Seminario',
                    'Taller'=> 'Taller',
                    'Trabajo de Investigación'=>'Trabajo de Investigación',
                ],
                'placeholder' => 'Seleccionar',
                'required'=> true,
            ])
            ->add('tituloActividad', TextType::class, [
                'required' => true,  // Makes the field required
                'label' => 'Título de la actividad', ]) // Optional: Add a label if you need one
            ->add('importe')

            ->add('tcCCM')
            ->add('taCCM')
            ->add('taProyecto')
            ->add('tcProyecto')
        ;


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Solicitud::class,
        ]);
    }
}
