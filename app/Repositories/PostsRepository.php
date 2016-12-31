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

    public function getPosts()
    {
        return $this->getModel()->with('comments')->get();
    }

    public function postUpdate($user_id , $post_id , $post)
    {
//        return $this->getModel()->where('id' , $post_id)->where('user_id' , $user_id)
//        ->update(['body' => $post]);

        $postData = $this->getModel()->find($post_id);
        $postData->body = $post;
        $postData->update();
        return $postData;
    }

}
