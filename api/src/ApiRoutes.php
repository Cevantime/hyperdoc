<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 01/11/18
 * Time: 22:30
 */

namespace App;

use App\Controller\ProfileController;
use App\Controller\TokenController;
use App\Entity\Content;
use Sherpa\Routing\Map;

class ApiRoutes
{
    public static function init(Map $map)
    {
        $map->crud(Content::class, null, '', '{/locale}');
        $map->get('profile', '/profile', ProfileController::class . '::getProfile');
        $map->delete('revoke_token', '/revoke/{token}', TokenController::class . '::revokeAccessToken');
    }
}