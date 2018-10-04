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
 * @Table(indexes={@Index(name="program_slug", columns={"slug"})})
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
     * @var string|null
     * @Column(type="string", nullable=true)
     */
    protected $language;

    /**
     * @Column(type="string")
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
     * @OneToMany(targetEntity="ProgramValue", mappedBy="programOutput", cascade="all")
     */
    protected $outputs;

    /**
     * @OneToMany(targetEntity="ProgramAssociation", mappedBy="wrapperProgram")
     * @var Collection
     */
    protected $wrapped;

    /**
     * @OneToMany(targetEntity="ProgramAssociation", mappedBy="wrappedProgram")
     * @var Collection
     */
    protected $wrappers;

    public function __construct()
    {
        $this->inputs = new ArrayCollection();
        $this->outputs = new ArrayCollection();
        $this->wrapped = new ArrayCollection();
        $this->wrappers = new ArrayCollection();
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
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
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
     */
    public function setLanguage(?string $language): void
    {
        $this->language = $language;
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
     */
    public function setInputs(Collection $inputs): void
    {
        $this->inputs = $inputs;
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

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
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
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
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
     */
    public function setWrapped(Collection $wrapped): void
    {
        $this->wrapped = $wrapped;
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
     */
    public function setWrappers(Collection $wrappers): void
    {
        $this->wrappers = $wrappers;
    }
}