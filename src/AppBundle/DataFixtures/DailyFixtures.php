<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 27/01/18
 * Time: 16:13
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Daily;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DailyFixtures extends Fixture
{
    private $locales = ['en' => 'en_US', 'fr' => 'fr_FR'];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 4; $i++) {

            $faker = \Faker\Factory::create();

            // cibler les propriétés non traduites
            $daily = new Daily();

            /*
             * image
             *      cibler la racine du projet
             *      le dossier ciblé doit exister
             */
            $daily->setImage(
                $faker->image(
                    'web/img/daily',
                    '400',
                    '400',
                    'sports',
                    false
                )
            );



            foreach($this->locales as $key => $value) {

                // use the factory to create a Faker\Generator instance
                $faker = \Faker\Factory::create($value);

                //créer des valeurs traduits pour les propriétés
                $name = ($key === 'fr') ? 'au quatidien' : 'daily';


                // méthode translate est fourni par doctrine behaviors
                $daily->translate($key)->setName($name . $i);
            }

            //méthode mergeNewTranslations est fourni par doctrine behaviors
            $daily->mergeNewTranslations();
            $manager->persist($daily);

        }

        $manager->flush();
    }
}