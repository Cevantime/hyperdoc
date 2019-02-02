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
use phpDocumentor\Reflection\Types\Parent_;
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
class Program extends Content
{
    /**
     * @var string|null
     * @Column(type="string", nullable=true)
     */
    protected $language;

    /**
     * @var string $code
     * @Column(type="string")
     */
    protected $code;

    /**
     * @var string $code
     * @Column(type="string")
     */
    protected $fullCode;

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Content
     */
    public function setCode(string $code): Content
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
     * @return Content
     */
    public function setFullCode(string $fullCode): Content
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
     * @return Content
     */
    public function setLanguage(?string $language): Content
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getOwnContent()
    {
        return $this->getCode();
    }

    /**
     * @param string $content
     * @return static
     */
    public function setOwnContent(string $content)
    {
        return $this->setFullCode($content);
    }

    /**
     * @return string
     */
    public function getFullContent()
    {
        return $this->getFullCode();
    }

    /**
     * @param string $content
     * @return static
     */
    public function setFullContent(string $content)
    {
        return $this->setFullCode($content);
    }
}