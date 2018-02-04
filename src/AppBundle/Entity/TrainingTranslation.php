<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
/**
 * Training
 *
 * @ORM\Entity()
 */
class TrainingTranslation
{
    // trait doctrine behaviors
    use ORMBehaviors\Translatable\Translation,
        ORMBehaviors\Sluggable\Sluggable;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="academy", type="text")
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
     * @return TrainingTranslation
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
     * @return TrainingTranslation
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
     * @return TrainingTranslation
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

