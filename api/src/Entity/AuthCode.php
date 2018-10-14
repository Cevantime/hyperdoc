<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 17:58
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;

/**
 * Class AccessToken
 * @package App\Entity
 * @Entity(repositoryClass="App\Repository\AuthCodeRepository")
 */
class AuthCode implements AuthCodeEntityInterface
{
    /**
     * @var int $id
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var string|null
     * @Column(type="string")
     */
    private $redirectUri;

    /**
     * @var string
     * @Column(type="string")
     */
    private $identifier;

    /**
     * @var \DateTime $expiryDateTime
     * @Column(type="datetime")
     */
    private $expiryDateTime;

    /**
     * @var int|null $userIdentifier
     */
    private $userIdentifier;

    /**
     * @var User $user
     * @ManyToOne(targetEntity="User", inversedBy="authCodes")
     */
    protected $user;

    /**
     * @var Client
     * @ManyToOne(targetEntity="Client", inversedBy="authCodes")
     */
    private $client;

    /**
     * @var Collection<Scope> $scopes
     * @OneToMany(targetEntity="Scope", mappedBy="authCode")
     */
    private $scopes;

    /**
     * @var bool
     * @Column(type="boolean", options={"default" : false})
     */
    private $revoked = false;

    public function __construct()
    {
        $this->scopes = new ArrayCollection();
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
     * @return bool
     */
    public function isRevoked(): bool
    {
        return $this->revoked;
    }

    /**
     * @param bool $revoked
     */
    public function setRevoked(bool $revoked): void
    {
        $this->revoked = $revoked;
    }

    /**
     * @return null|string
     */
    public function getRedirectUri(): ?string
    {
        return $this->redirectUri;
    }

    /**
     * @param null|string $redirectUri
     */
    public function setRedirectUri($redirectUri): void
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return \DateTime
     */
    public function getExpiryDateTime(): \DateTime
    {
        return $this->expiryDateTime;
    }

    /**
     * @param \DateTime $expiryDateTime
     */
    public function setExpiryDateTime(\DateTime $expiryDateTime): void
    {
        $this->expiryDateTime = $expiryDateTime;
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): ?int
    {
        return $this->userIdentifier;
    }

    /**
     * @param string $userIdentifier
     */
    public function setUserIdentifier($userIdentifier): void
    {
        $this->userIdentifier = $userIdentifier;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param ClientEntityInterface $client
     */
    public function setClient(ClientEntityInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @return Collection
     */
    public function getScopes(): Collection
    {
        return $this->scopes;
    }

    /**
     * @param Collection $scopes
     */
    public function setScopes(Collection $scopes): void
    {
        $this->scopes = $scopes;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Associate a scope with the token.
     *
     * @param ScopeEntityInterface $scope
     */
    public function addScope(ScopeEntityInterface $scope)
    {
        $scopeIdentifiers = array_map(function($scope){return $scope->getIdentifier();}, $this->scopes->toArray());

        if(in_array($scope->getIdentifier(), $scopeIdentifiers)) {
            return;
        }
        $this->scopes->add($scope);
        $scope->getAuthCodes()->add($scope);
    }
}