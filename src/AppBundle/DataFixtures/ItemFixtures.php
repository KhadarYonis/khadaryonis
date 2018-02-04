<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 02/02/18
 * Time: 10:14
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ItemFixtures extends Fixture
{
    private $locales = ['en' => 'en_US', 'fr' => 'fr_FR'];

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 4; $i++) {

            $faker = \Faker\Factory::create();

            // cibler les propriétés non traduites
            $item = new Item();

            $item->setImage(
                $faker->image(
                    'web/img/item',
                    '400',
                    '400',
                    'sports',
                    false
                )
            );

            $item->setDateCreate(new \DateTime('now'));
            $item->setModified(false);
            $item->setAuthor('khadar YONIS');

            // associer un article à une catégorie
            $item->setCategory(
                $this->getReference("category" . $faker->numberBetween(0, $i))
            );


            foreach($this->locales as $key => $value) {

                // use the factory to create a Faker\Generator instance
                $faker = \Faker\Factory::create($value);

                //créer des valeurs traduits pour les propriétés
                $name = ($key === 'fr') ? 'article' : 'item';
                $description = $faker->realText();

                // méthode translate est fourni par doctrine behaviors
                $item->translate($key)->setName($name . $i);
                $item->translate($key)->setDescription($description);
            }
            //méthode mergeNewTranslations est fourni par doctrine behaviors
            $item->mergeNewTranslations();


            $manager->persist($item);
        }
        $manager->flush();
    }
}