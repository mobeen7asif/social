<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\User;


class UsersRepository extends Repository
{
    public function __construct(User $user)
    {
        $this->setModel($user);
    }

}
