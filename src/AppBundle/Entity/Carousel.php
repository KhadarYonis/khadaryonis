<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carousel
 *
 * @ORM\Table(name="carousel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarouselRepository")
 */
class Carousel
{
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
     * @ORM\Column(name="image", type="string", length=100)
     */
    private $image;

    // Many Carousels have One Portfolio

    /**
     * @ORM\ManyToOne(targetEntity="Portfolio", inversedBy="carousels")
     * @ORM\JoinColumn(name="portfolio_id", referencedColumnName="id")
     */
    private $portfolio;


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
     * Set image
     *
     * @param string $image
     *
     * @return Carousel
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Set portfolio
     *
     * @param \AppBundle\Entity\Portfolio $portfolio
     *
     * @return Carousel
     */
    public function setPortfolio(\AppBundle\Entity\Portfolio $portfolio = null)
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    /**
     * Get portfolio
     *
     * @return \AppBundle\Entity\Portfolio
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }
}
