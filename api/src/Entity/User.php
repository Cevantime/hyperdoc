<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 12:17
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * Class User
 * @package App\Entity
 * @Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserEntityInterface
{
    /**
     * @var int $id
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var string $code
     * @Column(type="string")
     */
    protected $email;

    /**
     * @var string $fullCode
     * @Column(type="string")
     */
    protected $username;

    /**
     * @var string $fullCode
     * @Column(type="string")
     */
    protected $password;

    /**
     * @var Collection<Content> $programs
     * @OneToMany(targetEntity="Program", mappedBy="author")
     */
    protected $programs;

    /**
     * @var Collection<AccessToken> $accessTokens
     * @OneToMany(targetEntity="AccessToken", mappedBy="user")
     */
    protected $accessTokens;

    /**
     * @var Collection<AccessToken> $authCodes
     * @OneToMany(targetEntity="AuthCode", mappedBy="user")
     */
    protected $authCodes;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
        $this->accessTokens = new ArrayCollection();
        $this->authCodes = new ArrayCollection();
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
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    /**
     * @param Collection $programs
     * @return User
     */
    public function setPrograms(Collection $programs): User
    {
        $this->programs = $programs;
        return $this;
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
     * @return User
     */
    public function setAuthCodes(Collection $authCodes): User
    {
        $this->authCodes = $authCodes;
        return $this;
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

        $this->authCodes->add($authCode);
        $authCode->setUser($this);
    }

    /**
     * @param Collection $accessTokens
     */
    public function setAccessTokens(Collection $accessTokens): void
    {
        $this->accessTokens = $accessTokens;
    }

    /**
     * Return the user's identifier.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->id;
    }
}
