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
     * @ManyToOne(targetEntity="ContentValue", inversedBy="injections")
     * @var ContentValue
     */
    private $contentValue;

    /**
     * @ManyToOne(targetEntity="ContentAssociation", inversedBy="injections")
     * @var ContentAssociation
     */
    private $contentAssociationInput;

    /**
     * @ManyToOne(targetEntity="ContentAssociation", inversedBy="injections")
     * @var ContentAssociation
     */
    private $contentAssociationOutput;

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
     * @return ContentValue
     */
    public function getContentValue(): ContentValue
    {
        return $this->contentValue;
    }

    /**
     * @param ContentValue $contentValue
     * @return ValueInjection
     */
    public function setContentValue(ContentValue $contentValue): ValueInjection
    {
        $this->contentValue = $contentValue;
        return $this;
    }

    /**
     * @return ContentAssociation
     */
    public function getContentAssociationInput(): ContentAssociation
    {
        return $this->contentAssociationInput;
    }

    /**
     * @param ContentAssociation $contentAssociationInput
     * @return ValueInjection
     */
    public function setContentAssociationInput(ContentAssociation $contentAssociationInput): ValueInjection
    {
        $this->contentAssociationInput = $contentAssociationInput;
        return $this;
    }

    /**
     * @return ContentAssociation
     */
    public function getContentAssociationOutput(): ContentAssociation
    {
        return $this->contentAssociationOutput;
    }

    /**
     * @param ContentAssociation $contentAssociationOutput
     * @return ValueInjection
     */
    public function setContentAssociationOutput(ContentAssociation $contentAssociationOutput): ValueInjection
    {
        $this->contentAssociationOutput = $contentAssociationOutput;
        return $this;
    }


}