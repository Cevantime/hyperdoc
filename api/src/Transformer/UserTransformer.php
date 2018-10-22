<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 04/11/18
 * Time: 18:09
 */

namespace App\Transformer;


use App\Entity\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
        ];
    }
}