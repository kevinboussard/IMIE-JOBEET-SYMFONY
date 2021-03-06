<?php

namespace Jbt\KevinBoussardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Jbt\KevinBoussardBundle\Utils\Jobeet as Jobeet;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $jobs;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $category_affiliates;

    /**
     * @var string
     */
    private $active_jobs;

    /**
     * @var string
     */
    private $more_jobs;

    /**
     * @var string
     */
    private $slug;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->category_affiliates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * toString
     */
    public function __toString()
    {
        return $this->getName();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * Add job
     *
     * @param \Jbt\KevinBoussardBundle\Entity\Job $job
     *
     * @return Category
     */
    public function addJob(\Jbt\KevinBoussardBundle\Entity\Job $job)
    {
        $this->jobs[] = $job;

        return $this;
    }

    /**
     * Remove job
     *
     * @param \Jbt\KevinBoussardBundle\Entity\Job $job
     */
    public function removeJob(\Jbt\KevinBoussardBundle\Entity\Job $job)
    {
        $this->jobs->removeElement($job);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Add categoryAffiliate
     *
     * @param \Jbt\KevinBoussardBundle\Entity\CategoryAffiliate $categoryAffiliate
     *
     * @return Category
     */
    public function addCategoryAffiliate(\Jbt\KevinBoussardBundle\Entity\CategoryAffiliate $categoryAffiliate)
    {
        $this->category_affiliates[] = $categoryAffiliate;

        return $this;
    }

    /**
     * Remove categoryAffiliate
     *
     * @param \Jbt\KevinBoussardBundle\Entity\CategoryAffiliate $categoryAffiliate
     */
    public function removeCategoryAffiliate(\Jbt\KevinBoussardBundle\Entity\CategoryAffiliate $categoryAffiliate)
    {
        $this->category_affiliates->removeElement($categoryAffiliate);
    }

    /**
     * Get categoryAffiliates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoryAffiliates()
    {
        return $this->category_affiliates;
    }

    /**
     * Set activeJobs
     *
     * @return string
     */
    public function setActiveJobs($jobs)
    {
        $this->active_jobs = $jobs;
    }

    /**
     * Get activeJobs
     *
     * @return string
     */
    public function getActiveJobs()
    {
        return $this->active_jobs;
    }

    /**
     * Set moreJobs
     *
     * @param $jobs
     */
    public function setMoreJobs($jobs)
    {
        $this->more_jobs = $jobs >=  0 ? $jobs : 0;
    }

    /**
     * Get moreJobs
     *
     * @return string
     */
    public function getMoreJobs()
    {
        return $this->more_jobs;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @ORM\PrePersist
     */
    public function setSlugValueOnPrePersist()
    {
        $this->slug = Jobeet::slugify($this->getName());
    }

    /**
     * @ORM\PreUpdate
     */
    public function setSlugValueOnPreUpdate()
    {
        $this->slug = Jobeet::slugify($this->getName());
    }
}
