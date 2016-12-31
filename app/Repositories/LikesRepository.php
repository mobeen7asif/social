<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Like;
use App\Post;
use App\User;


class LikesRepository extends Repository
{
    public function __construct(Like $like)
    {
        $this->setModel($like);
    }

    public function getPosts()
    {
        return $this->getModel()->get();
    }
    public function likeOnPost()
    {

    }

}
