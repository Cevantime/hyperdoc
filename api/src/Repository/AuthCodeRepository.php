<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 19:35
 */

namespace App\Repository;


use App\Entity\AuthCode;
use App\Entity\Client;
use App\Entity\User;
use Aura\Router\Exception;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use Sherpa\Doctrine\ServiceRepository;

class AuthCodeRepository extends ServiceRepository implements AuthCodeRepositoryInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, AuthCode::class);
    }

    /**
     * Creates a new AuthCode
     *
     * @return AuthCodeEntityInterface
     */
    public function getNewAuthCode()
    {
        return new AuthCode();
    }

    /**
     * Persists a new auth code to permanent storage.
     *
     * @param AuthCodeEntityInterface $authCodeEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        $em = $this->getEntityManager();
        $em->merge($authCodeEntity);
        $em->flush();
    }

    /**
     * Revoke an auth code.
     *
     * @param string $codeId
     */
    public function revokeAuthCode($codeId)
    {
        $authCode = $this->findOneBy(['identifier' => $codeId]);

        if ($authCode) {
            $authCode->setRevoked(true);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Check if the auth code has been revoked.
     *
     * @param string $codeId
     *
     * @return bool Return true if this code has been revoked
     */
    public function isAuthCodeRevoked($codeId)
    {
        $authCode = $this->findOneBy(['identifier' => $codeId]);
        return !$authCode || $authCode->isRevoked();
    }
}