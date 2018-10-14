<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 12:40
 */

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use League\Fractal\Resource\Collection;
use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * Class Client
 * @package App\Entity
 * @Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client implements ClientEntityInterface
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
     * @Column(type="string")
     */
    protected $secret;

    /**
     * @var string|null
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var string|null
     * @Column(type="string")
     */
    protected $redirectUri;

    /**
     * @var Collection<AccessToken> $accessTokens
     * @OneToMany(targetEntity="AccessToken", mappedBy="client")
     */
    protected $accessTokens;

    /**
     * @var Collection<AuthCode> $authCodes
     * @OneToMany(targetEntity="AuthCode", mappedBy="client")
     */
    protected $authCodes;

    public function __construct()
    {
        $this->accessTokens = new ArrayCollection();
        $this->authCodes = new ArrayCollection();
    }

    /**
     * @param null|string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @param null|string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param null|string $redirectUri
     */
    public function setRedirectUri(?string $redirectUri): void
    {
        $this->redirectUri = $redirectUri;
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
     * Get the client's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Get the client's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

    /**
     * @return Collection
     */
    public function getAccessTokens(): Collection
    {
        return $this->accessTokens;
    }

    /**
     * @param Collection $accessTokens
     */
    public function setAccessTokens(Collection $accessTokens): void
    {
        $this->accessTokens = $accessTokens;
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

    public function addAccessToken(AccessToken $accessToken)
    {
        $identifiers = array_map(function($accessToken) {
            return $accessToken->getIdentifier();
        }, $this->accessTokens->toArray());

        if(in_array($accessToken->getIdentifier(), $identifiers)) {
            return ;
        }

        $this->accessTokens->add($accessToken);
        $accessToken->setUser($this);
    }

    public function addAuthCode(AuthCode $authCode)
    {
        $identifiers = array_map(function($authCode) {
            return $authCode->getIdentifier();
        }, $this->authCodes->toArray());

        if(in_array($authCode->getIdentifier(), $identifiers)) {
            return ;
        }

        $this->accessTokens->add($authCode);
        $authCode->setUser($this);
    }
}