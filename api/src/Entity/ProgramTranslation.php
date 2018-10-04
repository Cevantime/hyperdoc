<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 23/09/18
 * Time: 00:48
 */

namespace App\Entity;

use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * Class ProgramTranslation
 * @package App\Entity
 * @Entity
 */
class ProgramTranslation
{
    use Translation;

    /**
     * @var string|null $title
     * @Column(type="string")
     */
    protected $title;

    /**
     * @var string|null $description
     * @Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
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
}