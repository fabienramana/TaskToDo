<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la tâche',
                'required' => true,
            ])
            ->add('description', TextType::class, [
                'label' => 'Description de la tâche',
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Status de la tâche',
                'choices' => array(
                    Task::STATUS_ENDED => "Terminée",
                    Task::STATUS_PENDING => "En cours",
                    Task::STATUS_TO_DO => "A faire",
                ),
                'required' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
