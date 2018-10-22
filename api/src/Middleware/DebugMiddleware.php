<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 09/10/18
 * Time: 22:49
 */

namespace App\Middleware;

use App\Debug\DoctrineLogger;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Stream;

class DebugMiddleware implements MiddlewareInterface
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /**
         * @var EntityManagerInterface $em
         */
        $queryLogger = new DoctrineLogger();
        $this->em->getConnection()->getConfiguration()->setSQLLogger($queryLogger);
        $response = $handler->handle($request);
        if( $response->getHeaderLine('content-type') !== 'application/json') {
            return $response;
        }
        $data = json_decode($response->getBody(), true);
        $data['_debug'] = [
            'doctrine' => [
                'queries_count' => count($queryLogger->getQueryInfos()),
                'total_execution_time' => array_sum(array_map(function($qi){return $qi->getExecutionTime();}, $queryLogger->getQueryInfos())),
                'queries' => $queryLogger->getQueryInfos()
            ]
        ];
        $body = new Stream('php://temp', 'wb+');
        $body->write(json_encode($data));
        $body->rewind();
        return $response->withBody($body);
    }
}