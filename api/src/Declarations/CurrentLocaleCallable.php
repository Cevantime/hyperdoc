<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 23/09/18
 * Time: 01:33
 */

namespace App\Declarations;


use DI\Container;
use Psr\Http\Message\ServerRequestInterface;

class CurrentLocaleCallable
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __invoke()
    {
        if($this->container->has(ServerRequestInterface::class)) {
            /** @var ServerRequestInterface $request */
            $request = $this->container->get(ServerRequestInterface::class);
            return $request->getHeaderLine('Accept-Language');
        } else {
            return "en";
        }
    }
}