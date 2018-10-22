<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 09/10/18
 * Time: 20:11
 */

namespace App\Debug;


class QueryInfos implements \JsonSerializable
{
    protected $query;
    protected $executionTime;
    protected $params;
    protected $types;

    /**
     * QueryInfos constructor.
     * @param $query
     * @param $params
     * @param $types
     */
    public function __construct($query, $params, $types)
    {
        $this->query = $query;
        $this->params = $params;
        $this->types = $types;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query): void
    {
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params): void
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param mixed $types
     */
    public function setTypes($types): void
    {
        $this->types = $types;
    }

    /**
     * @return mixed
     */
    public function getExecutionTime()
    {
        return $this->executionTime;
    }

    /**
     * @param mixed $executionTime
     */
    public function setExecutionTime($executionTime): void
    {
        $this->executionTime = $executionTime;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'query' => $this->getQuery(),
            'execution_time' => $this->getExecutionTime(),
            'params' => $this->getParams(),
            'types' => $this->getTypes(),
        ];
    }
}