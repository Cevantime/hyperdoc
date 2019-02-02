<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 09/10/18
 * Time: 20:08
 */

namespace App\Debug;


use Doctrine\DBAL\Logging\SQLLogger;

class DoctrineLogger implements SQLLogger
{
    /**
     * @var QueryInfos[] $queryInfos
     */
    protected $queryInfos;
    /**
     * @var QueryInfos $currentQueryInfos
     */
    protected $currentQueryInfos;
    protected $microtime;

    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->currentQueryInfos = new QueryInfos($sql, $params, $types);
        $this->microtime = microtime(true);
    }

    public function stopQuery()
    {
        $this->currentQueryInfos->setExecutionTime(microtime(true) - $this->microtime);
        $this->queryInfos[] = $this->currentQueryInfos;
    }

    /**
     * @return QueryInfos[]
     */
    public function getQueryInfos(): array
    {
        return $this->queryInfos ?: [];
    }
}