<?php

namespace AppBundle\Form;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProjectType extends AbstractType
{
    /**
     * @var array
     */
    private $locales;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * TrainingType constructor.
     * @param array $locales
     * @param ManagerRegistry $doctrine
     * @param RequestStack $requestStack
     */

    public function __construct(array $locales, ManagerRegistry $doctrine, RequestStack $requestStack)
    {
        $this->locales = $locales;
        $this->doctrine = $doctrine;
        $this->requestStack = $requestStack;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();

        //dump($entity); exit;

        $builder
            ->add('dateBegin',DateType::class, [

                // add a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],

            ])
            ->add('dateEnd',DateType::class, [

                // add a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],

            ])
        ;

        foreach ($this->locales as $key => $value) {
            $builder
                ->add("name_$value", TextType::class, [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Name is empty'
                        ])
                    ],
                    'mapped' => false,
                    'data' => $entity->translate($value)->getName()
                ])
                ->add("academy_$value", TextType::class, [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Academy is empty'
                        ])
                    ],
                    'mapped' => false,
                    'data' => $entity->translate($value)->getAcademy()
                ])
                ->add("description_$value", TextareaType::class, [
                    'attr' => [
                        'class' => 'ckeditor'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Description is empty'
                        ])
                    ],
                    'mapped' => false,
                    'data' => $entity->translate($value)->getDescription()
                ])
            ;
        }

        //dump($entity); exit;
        // écouter : récuperer la saisie et de fusionner les traductions

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            // saisi du formulaire
            $data =  $event->getData();

            // données du formulaire
            $form = $event->getForm();
            $entity = $form->getData();

            // création des traductions
            foreach ($this->locales as $key => $value) {
                // méthode translate est fourni par doctrine behaviors
                $entity->translate($value)->setName($data["name_$value"]);
                $entity->translate($value)->setAcademy($data["academy_$value"]);
                $entity->translate($value)->setDescription($data["description_$value"]);
            }

            $entity->mergeNewTranslations();
            //dump($entity); exit;
        });

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Project'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_project';
    }


}
