<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 29/09/18
 * Time: 23:31
 */

namespace App\Entity;

/**
 * Class Program
 * @package App\Entity
 * @Entity()
 */
class ValueInjection
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $value;

    /**
     * @ManyToOne(targetEntity="ProgramValue", inversedBy="injections")
     * @var ProgramValue
     */
    private $programValue;

    /**
     * @ManyToOne(targetEntity="ProgramAssociation", inversedBy="injections")
     * @var ProgramAssociation
     */
    private $programAssociationInput;

    /**
     * @ManyToOne(targetEntity="ProgramAssociation", inversedBy="injections")
     * @var ProgramAssociation
     */
    private $programAssociationOutput;

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
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return ProgramValue
     */
    public function getProgramValue(): ProgramValue
    {
        return $this->programValue;
    }

    /**
     * @param ProgramValue $programValue
     */
    public function setProgramValue(ProgramValue $programValue): void
    {
        $this->programValue = $programValue;
    }

    /**
     * @return ProgramAssociation
     */
    public function getProgramAssociationInput(): ProgramAssociation
    {
        return $this->programAssociationInput;
    }

    /**
     * @param ProgramAssociation $programAssociationInput
     */
    public function setProgramAssociationInput(ProgramAssociation $programAssociationInput): void
    {
        $this->programAssociationInput = $programAssociationInput;
    }

    /**
     * @return ProgramAssociation
     */
    public function getProgramAssociationOutput(): ProgramAssociation
    {
        return $this->programAssociationOutput;
    }

    /**
     * @param ProgramAssociation $programAssociationOutput
     */
    public function setProgramAssociationOutput(ProgramAssociation $programAssociationOutput): void
    {
        $this->programAssociationOutput = $programAssociationOutput;
    }
}