<?php

namespace AppBundle\Form;

use AppBundle\Entity\Portfolio;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CarouselType extends AbstractType
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
     * CarouselType constructor.
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
        $builder
            ->add('image', FileType::class, [
                'data_class' => null,
                'constraints' => [
                    new NotBlank([
                        'message' => 'choose file'
                    ])
                ]
            ])
            ->add('portfolio', EntityType::class, [
                'class' => Portfolio::class,
                'choice_label' => 'id'
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Carousel'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_carousel';
    }


}
