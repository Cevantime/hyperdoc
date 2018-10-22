<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 12:50
 */

namespace App\Repository;


use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Sherpa\Doctrine\ServiceRepository;

class ClientRepository extends ServiceRepository implements ClientRepositoryInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Client::class);
    }

    /**
     * Get a client.
     *
     * @param string $clientIdentifier The client's identifier
     * @param null|string $grantType The grant type used (if sent)
     * @param null|string $clientSecret The client's secret (if sent)
     * @param bool $mustValidateSecret If true the client must attempt to validate the secret if the client
     *                                        is confidential
     *
     * @return ClientEntityInterface
     */
    public function getClientEntity($clientIdentifier, $grantType = null, $clientSecret = null, $mustValidateSecret = true)
    {
        $client = $this->findOneBy(['identifier' => $clientIdentifier]);
        if($mustValidateSecret && ($client === null || $client->getSecret() !== $clientSecret)) {
            return null;
        }
        return $client;
    }
}