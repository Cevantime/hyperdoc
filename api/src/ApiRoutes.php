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
use App\Entity\Program;
use Sherpa\Routing\Map;

class ApiRoutes
{
    public static function init(Map $map)
    {
        $map->crud(Program::class, null, '', '{/locale}');
        $map->get('profile', '/profile', ProfileController::class . '::getProfile');
        $map->delete('revoke_token', '/revoke', TokenController::class . '::revokeAccessToken');
    }
}