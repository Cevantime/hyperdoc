<?php

/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 16:43
 */

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class ContentValue
 * @package App\Entity
 * @Entity(repositoryClass="App\Repository\ContentValueRepository")
 */
class ContentValue
{
    /**
     * @var int $id
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var string|null $name
     * @Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @var string|null $type
     * @Column(type="string", nullable=true)
     */
    protected $type;

    /**
     * @var string|null
     * @Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @var string|null $value
     * @Column(type="string", nullable=true)
     */
    protected $value;

    /**
     * @var string|null $defaultValue
     * @Column(type="string", nullable=true)
     */
    protected $defaultValue;

    /**
     * @var Content
     * @ManyToOne(targetEntity="Content", inversedBy="inputs")
     */
    protected $contentInput;

    /**
     * @var Collection<Content>
     * @ManyToMany(targetEntity="Content", inversedBy="associatedInputs")
     */
    protected $contentsAssociatedInput;

    /**
     * @OneToMany(targetEntity="ValueInjection", mappedBy="contentValue")
     * @var Collection
     */
    protected $injections;

    public function __construct()
    {
        $this->injections = new ArrayCollection();
        $this->contentsAssociatedInput = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     * @return ContentValue
     */
    public function setName(?string $name): ContentValue
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return null|string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param null|string $value
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return null|string
     */
    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    /**
     * @param null|string $defaultValue
     */
    public function setDefaultValue(?string $defaultValue): void
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return Content
     */
    public function getContentInput(): Content
    {
        return $this->contentInput;
    }

    /**
     * @param Content $contentInput
     */
    public function setContentInput(Content $contentInput): void
    {
        $this->contentInput = $contentInput;
    }

    /**
     * @return Content
     */
    public function getContentOutput(): Content
    {
        return $this->contentOutput;
    }

    /**
     * @param Content $contentOutput
     */
    public function setContentOutput(Content $contentOutput): void
    {
        $this->contentOutput = $contentOutput;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Collection<Content>
     */
    public function getContentsAssociatedInput(): Collection
    {
        return $this->contentsAssociatedInput;
    }

    /**
     * @param Collection<Content> $contentsAssociatedInput
     */
    public function setContentsAssociatedInput(Collection $contentsAssociatedInput): void
    {
        $this->contentsAssociatedInput = $contentsAssociatedInput;
    }

    /**
     * @return Collection<ContentValue>
     */
    public function getInjections(): Collection
    {
        return $this->injections;
    }

    /**
     * @param Collection<ContentValue> $injections
     */
    public function setInjections(Collection $injections): void
    {
        $this->injections = $injections;
    }
}