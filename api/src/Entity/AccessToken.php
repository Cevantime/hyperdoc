<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 13:25
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Lcobucci\JWT\Token;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;

/**
 * Class AccessToken
 * @package App\Entity
 * @Entity(repositoryClass="App\Repository\AccessTokenRepository")
 */
class AccessToken implements AccessTokenEntityInterface
{
    use AccessTokenTrait;

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
     * @var \DateTime
     * @Column(type="date")
     */
    protected $expiryDateTime;

    /**
     * @var int
     */
    protected $userIdentifier;

    /**
     * @var User $user
     * @ManyToOne(targetEntity="User", inversedBy="accessTokens")
     */
    protected $user;

    /**
     * @var Client
     * @ManyToOne(targetEntity="Client", inversedBy="accessTokens")
     */
    protected $client;

    /**
     * @var Collection<Scope>
     * @ManyToMany(targetEntity="Scope", mappedBy="accessTokens")
     */
    protected $scopes;

    /**
     * @var Collection<RefreshToken> $refreshTokens
     * @OneToMany(targetEntity="RefreshToken", mappedBy="accessToken")
     */
    protected $refreshTokens;

    /**
     * @var bool $revoked
     * @Column(type="boolean", options={"default" : false})
     */
    protected $revoked;

    public function __construct()
    {
        $this->scopes = new ArrayCollection();
        $this->refreshTokens = new ArrayCollection();
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
     * @return int
     */
    public function getUserIdentifier(): int
    {
        return $this->userIdentifier;
    }

    /**
     * @param int $userIdentifier
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
     * @param Client $client
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
     * @param Collection $scopes
     */
    public function setScopes(Collection $scopes): void
    {
        $this->scopes = $scopes;
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
     * @return Collection
     */
    public function getRefreshTokens(): Collection
    {
        return $this->refreshTokens;
    }

    /**
     * @param Collection $refreshTokens
     */
    public function setRefreshTokens(Collection $refreshTokens): void
    {
        $this->refreshTokens = $refreshTokens;
    }

    /**
     * Associate a scope with the token.
     *
     * @param ScopeEntityInterface $scope
     */
    public function addScope(ScopeEntityInterface $scope)
    {
        $scopeIdentifiers = array_map(function($scope) {return $scope->getIdentifier();}, $this->getScopes());

        if(in_array($scope->getIdentifier(), $scopeIdentifiers)) {
            return;
        }

        $this->scopes->add($scope);
        $scope->getAccessTokens()->add($this);
    }
    /**
     * Associate a scope with the token.
     *
     * @param ScopeEntityInterface $refreshToken
     */
    public function addRefreshToken(RefreshTokenEntityInterface $refreshToken)
    {
        $refreshTokenIdentifiers = array_map(function($refreshToken) {return $refreshToken->getIdentifier();}, $this->getScopes());

        if(in_array($refreshToken->getIdentifier(), $refreshTokenIdentifiers)) {
            return;
        }

        $this->refreshTokens->add($refreshToken);
        $refreshToken->setAccessToken($this);
    }

}