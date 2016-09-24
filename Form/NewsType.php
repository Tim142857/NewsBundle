<?php

namespace Tleroch\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class NewsType extends AbstractType
{
    private $class;

    /**
     * @param string $class The news class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('date_display', DateType::class)
            ->add('image', HiddenType::class, array(
                'data_class' => null
            ))
            ->add('imageupload', FileType::class, array(
                'mapped' => false,
                'required' => false
            ))
            ->add('file', HiddenType::class, array(
                'data_class' => null
            ))
            ->add('fileupload', FileType::class, array(
                'mapped' => false,
                'required' => false
            ))
            ->add('active', ChoiceType::class, array(
                'choices' => array(
                    'No' => 0,
                    'Yes' => 1
                ),
                'multiple' => false,
                'expanded' => true,
                'data' => 1
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
            $news = $event->getData();

            if(!empty($news['image']))
            {
                $news['image'] = new File($options['folder'].$news['image']);
            }

            if(!empty($news['file']))
            {
                $news['file'] = new File($options['folder'].$news['file']);
            }

            $event->setData($news);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'folder' => null
        ));
    }
}