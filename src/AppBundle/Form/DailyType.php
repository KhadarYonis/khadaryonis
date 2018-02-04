<?php

namespace AppBundle\Form;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class DailyType extends AbstractType
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
     * DailyType constructor.
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
            ->add('image', FileType::class, [
                'data_class' => null,
                'constraints' => [
                    new NotBlank([
                        'message' => 'choose file'
                    ])
                ]
            ])
        ;


        foreach ($this->locales as $key => $value) {
            $builder
                ->add("name_$value", TextType::class, [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Name is not empty'
                        ])
                    ],
                    'mapped' => false,
                    'data' => $entity->translate($value)->getName()
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
            'data_class' => 'AppBundle\Entity\Daily'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_daily';
    }


}
