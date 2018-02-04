<?php

namespace AppBundle\Form;

use Doctrine\Common\Persistence\ManagerRegistry;
use Faker\Provider\fr_FR\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
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
     * ServiceType constructor.
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
        // $locale = $this->requestStack->getMasterRequest()->getLocale();

        $builder
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'first name is empty'
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'first name is empty'
                    ])
                ]
            ])
            ->add('age', NumberType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'age is empty'
                    ])
                ]

            ])
            ->add('cp', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'cp is empty'
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'city is empty'
                    ])
                ]
            ])
            ->add('region', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'region is empty'
                    ])
                ]
            ])
            ->add('country', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'country is empty'
                    ])
                ]
            ])
            ->add('phone', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'phone is empty'
                    ])
                ]

            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'first name is empty'
                    ])
                ]
            ])
        ;

        foreach ($this->locales as $key => $value) {
            $builder
                ->add("job_$value", TextType::class, [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Job is not empty'
                        ])
                    ],
                    'mapped' => false,
                    'data' => $entity->translate($value)->getJob()
                ])
                ->add("description_long_$value", TextareaType::class, [
                    'attr' => [
                        'class' => 'ckeditor'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Description long is not empty'
                        ])
                    ],
                    'mapped' => false,
                    'data' => $entity->translate($value)->getDescriptionLong()
                ])
                ->add("description_small_$value", TextareaType::class, [
                    'attr' => [
                        'class' => 'ckeditor'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Description small is not empty'
                        ])
                    ],
                    'mapped' => false,
                    'data' => $entity->translate($value)->getDescriptionSmall()
                ])
                ->add("intro_description_$value", TextareaType::class, [
                    'attr' => [
                        'class' => 'ckeditor'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Intro description is not empty'
                        ])
                    ],
                    'mapped' => false,
                    'data' => $entity->translate($value)->getIntroDescription()
                ])
            ;
        }

        //dump($entity); exit;
        // écouter : récuperer la saisie et de fusionner les traductions

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            // saisi du formulaire
            $data = $event->getData();

            // données du formulaire
            $form = $event->getForm();
            $entity = $form->getData();

            // création des traductions
            foreach ($this->locales as $key => $value) {
                // méthode translate est fourni par doctrine behaviors
                $entity->translate($value)->setJob($data["job_$value"]);
                $entity->translate($value)->setDescriptionSmall($data["description_small_$value"]);
                $entity->translate($value)->setDescriptionLong($data["description_long_$value"]);
                $entity->translate($value)->setIntroDescription($data["intro_description_$value"]);
            }

            $entity->mergeNewTranslations();
        });
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_contact';
    }


}
