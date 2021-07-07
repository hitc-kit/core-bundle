<?php

namespace HitcKit\CoreBundle\Form\Admin;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use HitcKit\CoreBundle\Entity\Node;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class NodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['required' => true, 'constraints' => [new NotBlank()]])
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('content', CKEditorType::class, ['required' => false])
            ->add('cancel', SubmitType::class, ['translation_domain' => 'HitcKitAdminBundle'])
            ->add('save', SubmitType::class, ['translation_domain' => 'HitcKitAdminBundle'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Node::class,
            'translation_domain' => 'HitcKitCoreBundle',
            'label_format' => '%name%'
        ]);
    }
}
