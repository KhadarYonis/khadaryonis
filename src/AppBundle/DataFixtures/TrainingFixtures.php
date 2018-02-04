<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 27/01/18
 * Time: 16:13
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Service;
use AppBundle\Entity\Training;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TrainingFixtures extends Fixture
{
    private $locales = ['en' => 'en_US', 'fr' => 'fr_FR'];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 4; $i++) {

            $faker = \Faker\Factory::create();

            // cibler les propriétés non traduites
            $training = new Training();


            $training->setDateBegin(new \DateTime('NOW'));
            $training->setDateEnd(new \DateTime('NOW'));

            //dump($training); exit;

            foreach($this->locales as $key => $value) {

                // use the factory to create a Faker\Generator instance
                $faker = \Faker\Factory::create($value);

                //créer des valeurs traduits pour les propriétés
                $name = ($key === 'fr') ? 'nom en français' : 'name in english';
                $academy = ($key === 'fr') ? 'academy en français' : 'academy in english';
                $description = ($key === 'fr') ? 'description en français' : 'description in english';


                // méthode translate est fourni par doctrine behaviors
                $training->translate($key)->setName($name . $i);
                $training->translate($key)->setAcademy($academy . $i);
                $training->translate($key)->setDescription($description . $i);
            }

            //méthode mergeNewTranslations est fourni par doctrine behaviors
            $training->mergeNewTranslations();
            $manager->persist($training);

        }

        $manager->flush();
    }

}