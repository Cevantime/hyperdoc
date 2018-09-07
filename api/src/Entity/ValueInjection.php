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
     * @return ValueInjection
     */
    public function setId(int $id): ValueInjection
    {
        $this->id = $id;
        return $this;
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
     * @return ValueInjection
     */
    public function setValue(string $value): ValueInjection
    {
        $this->value = $value;
        return $this;
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
     * @return ValueInjection
     */
    public function setProgramValue(ProgramValue $programValue): ValueInjection
    {
        $this->programValue = $programValue;
        return $this;
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
     * @return ValueInjection
     */
    public function setProgramAssociationInput(ProgramAssociation $programAssociationInput): ValueInjection
    {
        $this->programAssociationInput = $programAssociationInput;
        return $this;
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
     * @return ValueInjection
     */
    public function setProgramAssociationOutput(ProgramAssociation $programAssociationOutput): ValueInjection
    {
        $this->programAssociationOutput = $programAssociationOutput;
        return $this;
    }


}