<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 02/02/18
 * Time: 10:14
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    private $locales = ['en' => 'en_US', 'fr' => 'fr_FR'];

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 4; $i++) {
            // cibler les propriétés non traduites
            $skill = new Skill();

            $skill->setPercentage(rand(25, 75));

            foreach($this->locales as $key => $value) {

                // use the factory to create a Faker\Generator instance
                $faker = \Faker\Factory::create($value);

                //créer des valeurs traduits pour les propriétés
                $name = ($key === 'fr') ? 'technologie' : 'skill';
                $description = $faker->realText();

                // méthode translate est fourni par doctrine behaviors
                $skill->translate($key)->setName($name . $i);
                $skill->translate($key)->setDescription($description);
            }
            //méthode mergeNewTranslations est fourni par doctrine behaviors
            $skill->mergeNewTranslations();


            $manager->persist($skill);
        }
        $manager->flush();
    }
}