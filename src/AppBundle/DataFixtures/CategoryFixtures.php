<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 02/02/18
 * Time: 10:13
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends  Fixture
{
    private $locales = ['en' => 'en_US', 'fr' => 'fr_FR'];

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 4; $i++) {
            // cibler les propriétés non traduites
            $categorie = new Category();

            foreach($this->locales as $key => $value) {

                // use the factory to create a Faker\Generator instance
                $faker = \Faker\Factory::create($value);

                //créer des valeurs traduits pour les propriétés
                $name = ($key === 'fr') ? 'catégorie' : 'category';
                $description = $faker->realText();

                // méthode translate est fourni par doctrine behaviors
                $categorie->translate($key)->setName($name . $i);
                $categorie->translate($key)->setDescription($description);
            }
            //méthode mergeNewTranslations est fourni par doctrine behaviors
            $categorie->mergeNewTranslations();

            // stocker les catégories en mémoire
            $this->addReference("category$i", $categorie);

            $manager->persist($categorie);
        }
        $manager->flush();
    }
}