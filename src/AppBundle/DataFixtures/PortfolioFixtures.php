<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 02/02/18
 * Time: 10:14
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Portfolio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PortfolioFixtures extends  Fixture
{
    private $locales = ['en' => 'en_US', 'fr' => 'fr_FR'];

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 4; $i++) {

            $faker = \Faker\Factory::create();

            // cibler les propriétés non traduites
            $portfolio = new Portfolio();
            $portfolio->setDateBegin(new \DateTime('now'));
            $portfolio->setDateEnd(new \DateTime('now'));
            $portfolio->setWebsite('https://www.khadaryonis.fr');
            $portfolio->setCustomer('khadar Company');

            foreach($this->locales as $key => $value) {

                // use the factory to create a Faker\Generator instance
                $faker = \Faker\Factory::create($value);

                //créer des valeurs traduits pour les propriétés
                $name = ($key === 'fr') ? 'portfolioFr' : 'portfolioEN';
                $description = $faker->realText();

                // méthode translate est fourni par doctrine behaviors
                $portfolio->translate($key)->setName($name . $i);
                $portfolio->translate($key)->setDescription($description);
            }
            //méthode mergeNewTranslations est fourni par doctrine behaviors
            $portfolio->mergeNewTranslations();

            // stocker les catégories en mémoire
            $this->addReference($portfolio->getId());

            $manager->persist($portfolio);
        }
        $manager->flush();
    }
}