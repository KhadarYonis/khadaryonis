<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Entity\Skill;
use Doctrine\Common\Persistence\ManagerRegistry;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;

class PortfolioType extends AbstractType
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
     * PortfolioType constructor.
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
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // récupération des données du formulaire (ex: entité)
        $entity = $builder->getData();


        $locale = $this->requestStack->getMasterRequest()->getLocale();


        $builder
            ->add('customer', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'enter author'
                    ])
                ]
            ])
            ->add('website', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'enter author'
                    ])
                ]
            ])
            ->add('dateBegin', DateType::class, [

                // add a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],

            ])
            ->add('dateEnd', DateType::class, [

                // add a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],

            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id'
            ])
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'id',
                'expanded' => true,
                'multiple' => true,
                'label_attr' => array(
                    'class' => 'checkbox-inline'
                )
            ])
        ;

        // créer plusieurs champs selon les langues
        foreach ($this->locales as $key => $value) {
            /*
             * mapped : permet de définir si un champ est relié à une propriété de l'entité; par défaut true
             * data : permet de définir une valeur au champ
             */
            $builder
                // champ name
                ->add("name_$value", TextType::class , [
                    'mapped' => false,
                    'data' => $entity->translate($value)->getName(),
                    'attr' => [
                        'class' => 'ckeditor'
                    ]
                ])
                // champ description
                ->add("description_$value", TextareaType::class , [
                    'mapped' => false,
                    'data' => $entity->translate($value)->getDescription(),
                    'attr' => [
                        'class' => 'ckeditor'
                    ]
                ])
            ;
        }

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
            'data_class' => 'AppBundle\Entity\Portfolio'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_portfolio';
    }


}
