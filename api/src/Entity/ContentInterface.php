<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 21/11/18
 * Time: 22:34
 */

namespace App\Entity;


interface ContentInterface
{
    /**
     * @return string
     */
    public function getOwnContent();

    /**
     * @param string $content
     * @return static
     */
    public function setOwnContent(string $content);
    /**
     * @return string
     */
    public function getFullContent();
    /**
     * @param string $content
     * @return static
     */
    public function setFullContent(string $content);
}