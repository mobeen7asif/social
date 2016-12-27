<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Post;
use App\User;


class PostsRepository extends Repository
{
    public function __construct(Post $post)
    {
        $this->setModel($post);
    }

}
