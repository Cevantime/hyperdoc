<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 13:26
 */

namespace App\Repository;


use App\Entity\AccessToken;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use Sherpa\Doctrine\ServiceRepository;

class AccessTokenRepository extends ServiceRepository implements AccessTokenRepositoryInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, AccessToken::class);
    }

    /**
     * Create a new access token
     *
     * @param ClientEntityInterface $clientEntity
     * @param ScopeEntityInterface[] $scopes
     * @param mixed $userIdentifier
     *
     * @return AccessTokenEntityInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        return new AccessToken();
    }

    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface $accessTokenEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $this->getEntityManager()->persist($accessTokenEntity);
        $this->getEntityManager()->flush();
    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId)
    {
       $accessToken = $this->findOneBy(['identifier' => $tokenId]);

       if($accessToken) {
           $accessToken->setRevoked(true);
           $this->getEntityManager()->flush();
       }
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId)
    {
        $accessToken = $this->findOneBy(['identifier' => $tokenId]);
        return  ! $accessToken || $accessToken->isRevoked();
    }

    public function getTokenFromIdentifier($identifier)
    {
        return $this->findOneBy(['identifier' => $identifier]);
    }

    /**
     * @param $identifier
     * @return AccessToken|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTokenWithUserAndClientFromIdentifier($identifier)
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.user', 'u')
            ->addSelect('u')
            ->leftJoin('t.client', 'c')
            ->addSelect('c')
            ->where('t.identifier = :identifier')
            ->setParameter('identifier', $identifier)
            ->getQuery()
            ->getOneOrNullResult();
    }
}