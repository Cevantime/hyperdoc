<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 21/11/18
 * Time: 21:49
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * @Entity(repositoryClass="App\Repository\ContentRepository")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"content" = "Content", "program" = "Program"})
 * @Table(indexes={@Index(name="disriminator_index", columns={"discr"})})
 */
abstract class Content implements ContentInterface
{
    use Translatable;
    use Timestampable;

    /**
     * @var int $id
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string", unique=true)
     * @var string
     */
    protected $slug;

    /**
     * @OneToMany(targetEntity="ContentAssociation", mappedBy="wrapperContent", cascade="all")
     * @var Collection<ContentAssociation>
     */
    protected $wrapped;

    /**
     * @OneToMany(targetEntity="ContentAssociation", mappedBy="wrappedContent")
     * @var Collection<ContentAssociation>
     */
    protected $wrappers;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="programs")
     * @var User
     */
    protected $author;

    /**
     * @var Collection<ContentValue>
     * @OneToMany(targetEntity="ContentValue", mappedBy="contentInput", cascade="all")
     */
    protected $inputs;

    /**
     * @var Collection<ContentValue>
     * @ManyToMany(targetEntity="ContentValue", mappedBy="contentsAssociatedInput")
     */
    protected $associatedInputs;

    /**
     * @var ContentValue[]
     */
    protected $allInputs;

    public function __construct()
    {
        $this->wrapped = new ArrayCollection();
        $this->wrappers = new ArrayCollection();
        $this->inputs = new ArrayCollection();
        $this->associatedInputs = new ArrayCollection();
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
     * @return Collection<ContentAssociation>
     */
    public function getWrapped(): Collection
    {
        return $this->wrapped;
    }

    /**
     * @param Collection<ContentAssociation> $wrapped
     */
    public function setWrapped(Collection $wrapped): void
    {
        $this->wrapped = $wrapped;
    }

    /**
     * @return Collection<ContentAssociation>
     */
    public function getWrappers(): Collection
    {
        return $this->wrappers;
    }

    /**
     * @param Collection<ContentAssociation> $wrappers
     */
    public function setWrappers(Collection $wrappers): void
    {
        $this->wrappers = $wrappers;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    public function addWrapped(ContentAssociation $wrapped) : self
    {
        if($this->wrapped->contains($wrapped)) {
            return $this;
        }
        $this->wrapped->add($wrapped);
        $wrapped->setWrapperContent($this);
        return $this;
    }

    public function addInput(ContentValue $value): self
    {
        if($this->inputs->contains($value)) {
            return $this;
        }
        $this->inputs->add($value);
        $value->setContentInput($this);
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
     * @return Content
     */
    public function setInputs(Collection $inputs): Content
    {
        $this->inputs = $inputs;
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
     * @return Collection<ContentValue>
     */
    public function getAllInputs()
    {
        $inputs = new ArrayCollection($this->getInputs()->toArray());
        foreach ($this->getAssociatedInputs() as $input) {
            $inputs->add($input);
        }
        return $inputs;
    }

    public function getInputByName($name) {
        foreach ($this->inputs as $input) {
            if($input->getName() === $name) {
                return $input;
            }
        }
        return null;
    }

    /**
     * @param Collection $associatedInputs
     */
    public function setAssociatedInputs(Collection $associatedInputs): void
    {
        $this->associatedInputs = $associatedInputs;
    }

    public function addAssociatedInput(ContentValue $input)
    {
        if($this->associatedInputs->contains($input)) {
            return;
        }
        $this->associatedInputs->add($input);
        $input->getContentsAssociatedInput()->add($this);
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}