<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Comment;
use App\Like;
use App\Post;
use App\User;


class CommentsRepository extends Repository
{
    public function __construct(Comment $comment)
    {
        $this->setModel($comment);
    }


}
