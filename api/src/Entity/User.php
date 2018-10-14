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
 * Class Program
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
     * @var string $fullCode
     * @Column(type="string")
     */
    protected $locale;

    /**
     * @var Collection<Program> $programs
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
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
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
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
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
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
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
     */
    public function setPrograms(Collection $programs): void
    {
        $this->programs = $programs;
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
