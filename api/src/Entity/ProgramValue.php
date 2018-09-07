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
 * Class ProgramParameter
 * @package App\Entity
 * @Entity(repositoryClass="App\Repository\ProgramValueRepository")
 */
class ProgramValue
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
     * @var Program
     * @ManyToOne(targetEntity="Program", inversedBy="inputs")
     */
    protected $programInput;

    /**
     * @var Program
     * @ManyToMany(targetEntity="Program", inversedBy="associatedInputs")
     */
    protected $programsAssociatedInput;
    /**
     * @var Program
     * @ManyToOne(targetEntity="Program", inversedBy="outputs")
     */
    protected $programOutput;

    /**
     * @OneToMany(targetEntity="ValueInjection", mappedBy="programValue")
     * @var Collection
     */
    protected $injections;

    public function __construct()
    {
        $this->injections = new ArrayCollection();
        $this->programsAssociatedInput = new ArrayCollection();
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
     * @return ProgramValue
     */
    public function setName(?string $name): ProgramValue
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
     * @return Program
     */
    public function getProgramInput(): Program
    {
        return $this->programInput;
    }

    /**
     * @param Program $programInput
     */
    public function setProgramInput(Program $programInput): void
    {
        $this->programInput = $programInput;
    }

    /**
     * @return Program
     */
    public function getProgramOutput(): Program
    {
        return $this->programOutput;
    }

    /**
     * @param Program $programOutput
     */
    public function setProgramOutput(Program $programOutput): void
    {
        $this->programOutput = $programOutput;
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
     * @return Program
     */
    public function getProgramsAssociatedInput(): Program
    {
        return $this->programsAssociatedInput;
    }

    /**
     * @param Program $programsAssociatedInput
     */
    public function setProgramsAssociatedInput(Program $programsAssociatedInput): void
    {
        $this->programsAssociatedInput = $programsAssociatedInput;
    }

    /**
     * @return Collection
     */
    public function getInjections(): Collection
    {
        return $this->injections;
    }

    /**
     * @param Collection $injections
     */
    public function setInjections(Collection $injections): void
    {
        $this->injections = $injections;
    }
}