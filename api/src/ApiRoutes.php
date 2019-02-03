<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 01/11/18
 * Time: 22:30
 */

namespace App;

use App\Controller\ProfileController;
use App\Controller\ProgramController;
use App\Controller\TokenController;
use App\ElasticSearch\Adapter\ProgramAdapter;
use App\Entity\Program;
use App\Transformer\IndexedProgramTransformer;
use Sherpa\Routing\Map;

class ApiRoutes
{
    public static function init(Map $map)
    {
        $map->crud(Program::class, function (\Aura\Router\Map $map) {
            $map->get('search', '/search', ProgramController::class . '::search')
                ->setAdapter(ProgramAdapter::class)
                ->setTransformer(IndexedProgramTransformer::class);
//            dump($map); die;
        }, '', '{/locale}');
        $map->get('profile', '/profile', ProfileController::class . '::getProfile');
        $map->delete('revoke_token', '/revoke', TokenController::class . '::revokeAccessToken');
    }
}