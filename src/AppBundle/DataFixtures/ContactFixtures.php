<?php
/**
 * Created by PhpStorm.
 * User: khadar
 * Date: 27/01/18
 * Time: 16:13
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    private $locales = ['en' => 'en_US', 'fr' => 'fr_FR'];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 4; $i++) {

            $faker = \Faker\Factory::create();

            // cibler les propriétés non traduites
            $contact = new Contact();


            $contact->setFirstName('khadar '.$i);
            $contact->setLastName('Yonis '.$i);
            $contact->setAge(20+$i);
            $contact->setPhone("+33 07 14 25 36");
            $contact->setEmail("khadar.yonis$i@gmail.com");
            $contact->setCity('Paris '.$i);
            $contact->setCp('7500'.$i);
            $contact->setRegion("île-de-france");
            $contact->setCountry("France");



            //dump($training); exit;

            foreach($this->locales as $key => $value) {

                // use the factory to create a Faker\Generator instance
                $faker = \Faker\Factory::create($value);

                //créer des valeurs traduits pour les propriétés
                $job = ($key === 'fr') ? 'job en francias' : 'job in english';
                $description_small = ($key === 'fr') ? 'description court en français' : 'description small in english';
                $description_long = ($key === 'fr') ? 'description longe en français' : 'description long in english';
                $intro_description= ($key === 'fr') ? 'introduction description en français' : 'description introduction in english';


                // méthode translate est fourni par doctrine behaviors
                $contact->translate($key)->setJob($job . $i);
                $contact->translate($key)->setDescriptionSmall($description_small . $i);
                $contact->translate($key)->setDescriptionLong($description_long . $i);
                $contact->translate($key)->setIntroDescription($intro_description . $i);
            }

            //méthode mergeNewTranslations est fourni par doctrine behaviors
            $contact->mergeNewTranslations();
            $manager->persist($contact);

        }

        $manager->flush();
    }

}