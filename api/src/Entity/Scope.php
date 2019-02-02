<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 13:05
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;

/**
 * Class Scope
 * @package App\Entity
 * @Entity(repositoryClass="App\Repository\ScopeRepository")
 */
class Scope implements ScopeEntityInterface
{

    /**
     * @var int $id
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", unique=true)
     */
    protected $identifier;

    /**
     * @var string
     * @Column(type="text")
     */
    protected $description;

    /**
     * @var Collection<AccessToken> $accessTokens
     * @ManyToMany(targetEntity="AccessToken", mappedBy="scopes")
     */
    protected $accessTokens;

    /**
     * @var Collection<AuthCode> $authCodes
     * @ManyToMany(targetEntity="AuthCode", inversedBy="scopes")
     */
    protected $authCodes;

    public function __construct()
    {
        $this->accessTokens = new ArrayCollection();
        $this->authCodes = new ArrayCollection();
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get the scope's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return Collection
     */
    public function getAccessTokens(): Collection
    {
        return $this->accessTokens;
    }

    /**
     * @return Collection
     */
    public function getAuthCodes(): Collection
    {
        return $this->authCodes;
    }

    /**
     * @param Collection $authCodes
     */
    public function setAuthCodes(Collection $authCodes): void
    {
        $this->authCodes = $authCodes;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            "identifier" => $this->identifier,
            "description" => $this->description
        ];
    }
}