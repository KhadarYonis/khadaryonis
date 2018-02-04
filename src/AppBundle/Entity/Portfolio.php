<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
/**
 * Portfolio
 *
 * @ORM\Table(name="portfolio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PortfolioRepository")
 */
class Portfolio
{
    // trait doctrine behaviors
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="customer", type="string", length=50)
     */
    private $customer;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=100)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="date_begin", type="datetime")
     */
    private $dateBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime")
     */
    private $dateEnd;


    /**
     * One Portfolio has Many Carousel.
     * @ORM\OneToMany(targetEntity="Carousel", mappedBy="portfolio")
     */
    private $carousels;


    /**
     * Many Portfolio have One Category.
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="portfolios")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;


    /**
     * Many Portfolio have Many Skills.
     * @ORM\ManyToMany(targetEntity="Skill", inversedBy="portfolios")
     * @ORM\JoinTable(name="portfolios_skills")
     */
    private $skills;

    public function __construct() {
        $this->carousels = new ArrayCollection();
        $this->skills = new \Doctrine\Common\Collections\ArrayCollection();
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set customer
     *
     * @param string $customer
     *
     * @return Portfolio
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Portfolio
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     *
     * @return Portfolio
     */
    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Get dateBegin
     *
     * @return string
     */
    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return Portfolio
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }


    /**
     * Add carousel
     *
     * @param \AppBundle\Entity\Carousel $carousel
     *
     * @return Portfolio
     */
    public function addCarousel(\AppBundle\Entity\Carousel $carousel)
    {
        $this->carousels[] = $carousel;

        return $this;
    }

    /**
     * Remove carousel
     *
     * @param \AppBundle\Entity\Carousel $carousel
     */
    public function removeCarousel(\AppBundle\Entity\Carousel $carousel)
    {
        $this->carousels->removeElement($carousel);
    }

    /**
     * Get carousels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCarousels()
    {
        return $this->carousels;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Portfolio
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add skill
     *
     * @param \AppBundle\Entity\Skill $skill
     *
     * @return Portfolio
     */
    public function addSkill(\AppBundle\Entity\Skill $skill)
    {
        $this->skills[] = $skill;

        return $this;
    }

    /**
     * Remove skill
     *
     * @param \AppBundle\Entity\Skill $skill
     */
    public function removeSkill(\AppBundle\Entity\Skill $skill)
    {
        $this->skills->removeElement($skill);
    }

    /**
     * Get skills
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSkills()
    {
        return $this->skills;
    }
}
