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
 * Class Program
 * @package App\Entity
 * @Entity()
 */
class ProgramAssociation
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Program", inversedBy="wrapped")
     * @var Program
     */
    private $wrapperProgram;

    /**
     * @ManyToOne(targetEntity="Program", inversedBy="wrappers")
     * @var Program
     */
    private $wrappedProgram;

    /**
     * @OneToMany(targetEntity="ValueInjection", mappedBy="programAssociationInput", cascade="all")
     * @var ValueInjection[]
     */
    private $injections;

    /**
     * @OneToMany(targetEntity="ValueInjection", mappedBy="programAssociationOutput")
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
     * @return ProgramAssociation
     */
    public function setId(int $id): ProgramAssociation
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Program
     */
    public function getWrapperProgram(): Program
    {
        return $this->wrapperProgram;
    }

    /**
     * @param Program $wrapperProgram
     * @return ProgramAssociation
     */
    public function setWrapperProgram(Program $wrapperProgram): ProgramAssociation
    {
        $this->wrapperProgram = $wrapperProgram;
        return $this;
    }

    /**
     * @return Program
     */
    public function getWrappedProgram(): Program
    {
        return $this->wrappedProgram;
    }

    /**
     * @param Program $wrappedProgram
     * @return ProgramAssociation
     */
    public function setWrappedProgram(Program $wrappedProgram): ProgramAssociation
    {
        $this->wrappedProgram = $wrappedProgram;
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
     * @return ProgramAssociation
     */
    public function setInjections(Collection $injections): ProgramAssociation
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
     * @return ProgramAssociation
     */
    public function setReceptions(Collection $receptions): ProgramAssociation
    {
        $this->receptions = $receptions;
        return $this;
    }

    public function addInjection(ValueInjection $injection) : ProgramAssociation
    {
        if($this->injections->contains($injection)) {
            return $this;
        }

        $this->injections->add($injection);
        $injection->setProgramAssociationInput($this);
        return $this;
    }
}