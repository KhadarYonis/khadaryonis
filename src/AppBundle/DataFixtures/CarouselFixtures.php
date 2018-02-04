<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 02/02/18
 * Time: 10:15
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Carousel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CarouselFixtures extends  Fixture
{

    public function load(ObjectManager $manager)
    {


        for($i = 0; $i < 4; $i++) {

            // use the factory to create a Faker\Generator instance
            $faker = \Faker\Factory::create();

            // cibler les propriétés non traduites
            $carousel = new Carousel();

            $carousel->setImage(
                $faker->image(
                    'web/img/carousel',
                    '400',
                    '400',
                    'sports',
                    false
                )
            );


            // associer un carousel à un portfolio

            //$carousel->setPortfolio(
            //    $this->getReference()
            //);

            $carousel->setPortfolio(
                $carousel->getId()
            );

            $manager->persist($carousel);
        }
        $manager->flush();
    }
}