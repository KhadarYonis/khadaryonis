<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Daily
 *
 * @ORM\Entity()
 */
class DailyTranslation
{
    // trait doctrine behaviors
    use ORMBehaviors\Translatable\Translation,
        ORMBehaviors\Sluggable\Sluggable;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return DailyTranslation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    public function getSluggableFields()
    {
        return [ 'name' ];
    }

    public function generateSlugValue($values)
    {
        return implode('-', $values);
    }
}

