<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 29/09/18
 * Time: 23:19
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class ValueInjection
 * @package App\Entity
 * @Entity()
 */
class ContentAssociation
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Content", inversedBy="wrapped")
     * @var Content
     */
    private $wrapperContent;

    /**
     * @ManyToOne(targetEntity="Content", inversedBy="wrappers")
     * @var Content
     */
    private $wrappedContent;

    /**
     * @OneToMany(targetEntity="ValueInjection", mappedBy="contentAssociationInput", cascade="all")
     * @var ValueInjection[]
     */
    private $injections;

    /**
     * @OneToMany(targetEntity="ValueInjection", mappedBy="contentAssociationOutput")
     * @var ValueInjection[]
     */
    private $receptions;

    public function __construct()
    {
        $this->injections = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ContentAssociation
     */
    public function setId(int $id): ContentAssociation
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Content
     */
    public function getWrapperContent(): Content
    {
        return $this->wrapperContent;
    }

    /**
     * @param Content $wrapperContent
     * @return ContentAssociation
     */
    public function setWrapperContent(Content $wrapperContent): ContentAssociation
    {
        $this->wrapperContent = $wrapperContent;
        return $this;
    }

    /**
     * @return Content
     */
    public function getWrappedContent(): Content
    {
        return $this->wrappedContent;
    }

    /**
     * @param Content $wrappedContent
     * @return ContentAssociation
     */
    public function setWrappedContent(Content $wrappedContent): ContentAssociation
    {
        $this->wrappedContent = $wrappedContent;
        return $this;
    }

    /**
     * @return ValueInjection[]
     */
    public function getInjections(): Collection
    {
        return $this->injections;
    }

    /**
     * @param ValueInjection[] $injections
     * @return ContentAssociation
     */
    public function setInjections(Collection $injections): ContentAssociation
    {
        $this->injections = $injections;
        return $this;
    }

    /**
     * @return ValueInjection[]
     */
    public function getReceptions(): Collection
    {
        return $this->receptions;
    }

    /**
     * @param ValueInjection[] $receptions
     * @return ContentAssociation
     */
    public function setReceptions(Collection $receptions): ContentAssociation
    {
        $this->receptions = $receptions;
        return $this;
    }

    public function addInjection(ValueInjection $injection) : ContentAssociation
    {
        if($this->injections->contains($injection)) {
            return $this;
        }

        $this->injections->add($injection);
        $injection->setContentAssociationInput($this);
        return $this;
    }
}