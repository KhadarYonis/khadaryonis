<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
/**
 * Category
 *
 * @ORM\Entity()
 */
class CategoryTranslation
{
    // trait doctrine behaviors
    use ORMBehaviors\Translatable\Translation,
        ORMBehaviors\Sluggable\Sluggable;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return CategoryTranslation
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CategoryTranslation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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

