<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 27/01/18
 * Time: 16:13
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProjectFixtures extends Fixture
{
    private $locales = ['en' => 'en_US', 'fr' => 'fr_FR'];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 4; $i++) {

            $faker = \Faker\Factory::create();

            // cibler les propriétés non traduites
            $project = new Project();


            $project->setDateBegin(new \DateTime('NOW'));
            $project->setDateEnd(new \DateTime('NOW'));

            //dump($training); exit;

            foreach($this->locales as $key => $value) {

                // use the factory to create a Faker\Generator instance
                $faker = \Faker\Factory::create($value);

                //créer des valeurs traduits pour les propriétés
                $name = ($key === 'fr') ? 'nom en français' : 'name in english';
                $academy = ($key === 'fr') ? 'academy en français' : 'academy in english';
                $description = ($key === 'fr') ? 'description en français' : 'description in english';


                // méthode translate est fourni par doctrine behaviors
                $project->translate($key)->setName($name . $i);
                $project->translate($key)->setAcademy($academy . $i);
                $project->translate($key)->setDescription($description . $i);
            }

            //méthode mergeNewTranslations est fourni par doctrine behaviors
            $project->mergeNewTranslations();
            $manager->persist($project);

        }

        $manager->flush();
    }

}