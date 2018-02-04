<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 27/01/18
 * Time: 16:13
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    private $locales = ['en' => 'en_US', 'fr' => 'fr_FR'];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 4; $i++) {

            $faker = \Faker\Factory::create();

            // cibler les propriétés non traduites
            $service = new Service();

            /*
             * image
             *      cibler la racine du projet
             *      le dossier ciblé doit exister
             */
            $service->setImage(
                $faker->image(
                    'web/img/service',
                    '400',
                    '400',
                    'nature',
                    false
                )
            );



            foreach($this->locales as $key => $value) {

                // use the factory to create a Faker\Generator instance
                $faker = \Faker\Factory::create($value);

                //créer des valeurs traduits pour les propriétés
                $name = ($key === 'fr') ? 'service en français' : 'service in english';
                $description = ($key === 'fr') ? 'description en français' : 'description in english';


                // méthode translate est fourni par doctrine behaviors
                $service->translate($key)->setName($name . $i);
                $service->translate($key)->setDescription($description . $i);
            }

            //méthode mergeNewTranslations est fourni par doctrine behaviors
            $service->mergeNewTranslations();
            $manager->persist($service);

        }

        $manager->flush();
    }

}