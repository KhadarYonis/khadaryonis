<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
/**
 * Project
 *
 * @ORM\Entity()
 */
class ProjectTranslation
{
    // trait doctrine behaviors
    use ORMBehaviors\Translatable\Translation,
        ORMBehaviors\Sluggable\Sluggable;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="academy", type="string", length=50)
     */
    private $academy;

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
     * @return ProjectTranslation
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
     * Set academy
     *
     * @param string $academy
     *
     * @return ProjectTranslation
     */
    public function setAcademy($academy)
    {
        $this->academy = $academy;

        return $this;
    }

    /**
     * Get academy
     *
     * @return string
     */
    public function getAcademy()
    {
        return $this->academy;
    }


    /**
     * Set description
     *
     * @param string $description
     *
     * @return ProjectTranslation
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

