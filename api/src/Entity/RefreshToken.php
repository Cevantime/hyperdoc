<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 19:58
 */

namespace App\Entity;


use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

/**
 * Class AccessToken
 * @package App\Entity
 * @Entity(repositoryClass="App\Repository\RefreshTokenRepository")
 */
class RefreshToken implements RefreshTokenEntityInterface
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
     * @var \DateTime
     * @Column(type="datetime")
     */
    protected $expiryDateTime;

    /**
     * @var AccessToken $accessToken
     * @ManyToOne(targetEntity="AccessToken", inversedBy="refreshTokens")
     */
    protected $accessToken;

    /**
     * @var bool $revoked
     * @Column(type="boolean", options={"default" : false})
     */
    protected $revoked = false;

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
     * @return AccessToken
     */
    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @param AccessTokenEntityInterface $accessToken
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken): void
    {
        $this->accessToken = $accessToken;
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
}