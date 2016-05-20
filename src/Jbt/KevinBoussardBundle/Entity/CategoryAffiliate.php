<?php

namespace Jbt\KevinBoussardBundle\Entity;

/**
 * CategoryAffiliate
 */
class CategoryAffiliate
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Jbt\KevinBoussardBundle\Entity\Category
     */
    private $category;

    /**
     * @var \Jbt\KevinBoussardBundle\Entity\Affiliate
     */
    private $affiliate;


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
     * Set category
     *
     * @param \Jbt\KevinBoussardBundle\Entity\Category $category
     *
     * @return CategoryAffiliate
     */
    public function setCategory(\Jbt\KevinBoussardBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Jbt\KevinBoussardBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set affiliate
     *
     * @param \Jbt\KevinBoussardBundle\Entity\Affiliate $affiliate
     *
     * @return CategoryAffiliate
     */
    public function setAffiliate(\Jbt\KevinBoussardBundle\Entity\Affiliate $affiliate = null)
    {
        $this->affiliate = $affiliate;

        return $this;
    }

    /**
     * Get affiliate
     *
     * @return \Jbt\KevinBoussardBundle\Entity\Affiliate
     */
    public function getAffiliate()
    {
        return $this->affiliate;
    }
}
