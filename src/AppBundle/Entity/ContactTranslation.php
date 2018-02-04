<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Contact
 *
 * @ORM\Entity()
 */
class ContactTranslation
{
    // trait doctrine behaviors
    use ORMBehaviors\Translatable\Translation,
        ORMBehaviors\Sluggable\Sluggable;


    /**
     * @var string
     *
     * @ORM\Column(name="job", type="text")
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="description_long", type="text")
     */
    private $descriptionLong;

    /**
     * @var string
     *
     * @ORM\Column(name="description_small", type="text")
     */
    private $descriptionSmall;

    /**
     * @var string
     *
     * @ORM\Column(name="intro_description", type="text")
     */
    private $introDescription;



    /**
     * Set job
     *
     * @param string $job
     *
     * @return ContactTranslation
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set descriptionLong
     *
     * @param string $descriptionLong
     *
     * @return ContactTranslation
     */
    public function setDescriptionLong($descriptionLong)
    {
        $this->descriptionLong = $descriptionLong;

        return $this;
    }

    /**
     * Get descriptionLong
     *
     * @return string
     */
    public function getDescriptionLong()
    {
        return $this->descriptionLong;
    }

    /**
     * Set descriptionSmall
     *
     * @param string $descriptionSmall
     *
     * @return ContactTranslation
     */
    public function setDescriptionSmall($descriptionSmall)
    {
        $this->descriptionSmall = $descriptionSmall;

        return $this;
    }

    /**
     * Get descriptionSmall
     *
     * @return string
     */
    public function getDescriptionSmall()
    {
        return $this->descriptionSmall;
    }

    /**
     * Set introDescription
     *
     * @param string $introDescription
     *
     * @return ContactTranslation
     */
    public function setIntroDescription($introDescription)
    {
        $this->introDescription = $introDescription;

        return $this;
    }

    /**
     * Get introDescription
     *
     * @return string
     */
    public function getIntroDescription()
    {
        return $this->introDescription;
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

