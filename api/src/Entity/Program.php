<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 16:35
 */

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use phpDocumentor\Reflection\Types\String_;


/**
 * Class Program
 * @package App\Entity
 * @Entity(repositoryClass="App\Repository\ProgramRepository")
 * @method string getDescription()
 * @method string setDescription(?string $description)
 * @method string setTitle(?string $title)
 * @method string getTitle()
 */
class Program
{
    use Translatable;
    use Timestampable;

    /**
     * @var int $id
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var string $code
     * @Column(type="text")
     */
    protected $code;

    /**
     * @var string $fullCode
     * @Column(type="text")
     */
    protected $fullCode;

    /**
     * @var string|null
     * @Column(type="string", nullable=true)
     */
    protected $language;

    /**
     * @Column(type="string", unique=true)
     * @var string
     */
    protected $slug;

    /**
     * @var Collection
     * @OneToMany(targetEntity="ProgramValue", mappedBy="programInput", cascade="all")
     */
    protected $inputs;

    /**
     * @var Collection
     * @ManyToMany(targetEntity="ProgramValue", mappedBy="programsAssociatedInput")
     */
    protected $associatedInputs;

    /**
     * @var Collection
     * @OneToMany(targetEntity="ProgramValue", mappedBy="programOutput", cascade="all")
     */
    protected $outputs;

    /**
     * @OneToMany(targetEntity="ProgramAssociation", mappedBy="wrapperProgram", cascade="all")
     * @var Collection
     */
    protected $wrapped;

    /**
     * @OneToMany(targetEntity="ProgramAssociation", mappedBy="wrappedProgram")
     * @var Collection
     */
    protected $wrappers;

    /**
     * @var ProgramValue[]
     */
    protected $allInputs;

    public function __construct()
    {
        $this->inputs = new ArrayCollection();
        $this->outputs = new ArrayCollection();
        $this->wrapped = new ArrayCollection();
        $this->wrappers = new ArrayCollection();
        $this->associatedInputs = new ArrayCollection();
    }

    public function addInput(ProgramValue $value): self
    {
        if($this->inputs->contains($value)) {
            return $this;
        }
        $this->inputs->add($value);
        $value->setProgramInput($this);
        return $this;
    }

    public function addWrapped(ProgramAssociation $wrapped) : self
    {
        if($this->wrapped->contains($wrapped)) {
            return $this;
        }
        $this->wrapped->add($wrapped);
        $wrapped->setWrapperProgram($this);
        return $this;
    }

    /**
     * @return Collection
     */
    public function getOutputs(): Collection
    {
        return $this->outputs;
    }

    /**
     * @param Collection $outputs
     */
    public function setOutputs(Collection $outputs): void
    {
        $this->outputs = $outputs;
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
     * @return Program
     */
    public function setId(int $id): Program
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Program
     */
    public function setCode(string $code): Program
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullCode(): string
    {
        return $this->fullCode;
    }

    /**
     * @param string $fullCode
     * @return Program
     */
    public function setFullCode(string $fullCode): Program
    {
        $this->fullCode = $fullCode;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param null|string $language
     * @return Program
     */
    public function setLanguage(?string $language): Program
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Program
     */
    public function setSlug(string $slug): Program
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getInputs(): Collection
    {
        return $this->inputs;
    }

    /**
     * @param Collection $inputs
     * @return Program
     */
    public function setInputs(Collection $inputs): Program
    {
        $this->inputs = $inputs;
        return $this;
    }

    /**
     * @return ProgramAssociation[]
     */
    public function getWrapped(): Collection
    {
        return $this->wrapped;
    }

    /**
     * @param Collection $wrapped
     * @return Program
     */
    public function setWrapped(Collection $wrapped): Program
    {
        $this->wrapped = $wrapped;
        return $this;
    }

    /**
     * @return ProgramAssociation[]
     */
    public function getWrappers(): Collection
    {
        return $this->wrappers;
    }

    /**
     * @param Collection $wrappers
     * @return Program
     */
    public function setWrappers(Collection $wrappers): Program
    {
        $this->wrappers = $wrappers;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getAssociatedInputs(): Collection
    {
        return $this->associatedInputs;
    }

    /**
     * @return Collection<ProgramValue>
     */
    public function getAllInputs()
    {
        $inputs = new ArrayCollection($this->getInputs()->toArray());
        foreach ($this->getAssociatedInputs() as $input) {
            $inputs->add($input);
        }
        return $inputs;
    }

    /**
     * @param Collection $associatedInputs
     */
    public function setAssociatedInputs(Collection $associatedInputs): void
    {
        $this->associatedInputs = $associatedInputs;
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}