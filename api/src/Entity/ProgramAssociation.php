<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 29/09/18
 * Time: 23:19
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

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
     * @OneToMany(targetEntity="ValueInjection", mappedBy="programAssociationInput")
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
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     */
    public function setWrapperProgram(Program $wrapperProgram): void
    {
        $this->wrapperProgram = $wrapperProgram;
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
     */
    public function setWrappedProgram(Program $wrappedProgram): void
    {
        $this->wrappedProgram = $wrappedProgram;
    }

    /**
     * @return ValueInjection[]
     */
    public function getInjections(): array
    {
        return $this->injections;
    }

    /**
     * @param ValueInjection[] $injections
     */
    public function setInjections(array $injections): void
    {
        $this->injections = $injections;
    }

    /**
     * @return ValueInjection[]
     */
    public function getReceptions(): array
    {
        return $this->receptions;
    }

    /**
     * @param ValueInjection[] $receptions
     */
    public function setReceptions(array $receptions): void
    {
        $this->receptions = $receptions;
    }
}