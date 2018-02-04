<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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


    // Relation avec Item (article)


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * One Category has Many Items.
     * @ORM\OneToMany(targetEntity="Item", mappedBy="category")
     */
    private $items;

    /**
     * One Category has Many portfolios.
     * @ORM\OneToMany(targetEntity="Portfolio", mappedBy="category")
     */
    private $portfolios;


    public function __construct() {
        $this->items = new ArrayCollection();
        $this->portfolios = new ArrayCollection();
    }


    /**
     * Add item
     *
     * @param \AppBundle\Entity\Item $item
     *
     * @return Category
     */
    public function addItem(\AppBundle\Entity\Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\Item $item
     */
    public function removeItem(\AppBundle\Entity\Item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add portfolio
     *
     * @param \AppBundle\Entity\Portfolio $portfolio
     *
     * @return Category
     */
    public function addPortfolio(\AppBundle\Entity\Portfolio $portfolio)
    {
        $this->portfolios[] = $portfolio;

        return $this;
    }

    /**
     * Remove portfolio
     *
     * @param \AppBundle\Entity\Portfolio $portfolio
     */
    public function removePortfolio(\AppBundle\Entity\Portfolio $portfolio)
    {
        $this->portfolios->removeElement($portfolio);
    }

    /**
     * Get portfolios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPortfolios()
    {
        return $this->portfolios;
    }
}
