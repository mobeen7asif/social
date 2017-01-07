<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Comment;
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

    public function getPersonPosts($user_id)
    {
        $commentsTable = (new CommentsRepository(new Comment()))->getModel()->getTable();
        $postsTable = $this->getModel()->getTable();

//        return $this->getModel()->select($postsTable.".body", $commentsTable.".comment")
//            ->leftJoin($commentsTable, $commentsTable.".post_id", "=", $postsTable.".id")
//            ->where($postsTable.".user_id", $user_id)->get();
//            //->where('user_id',$user_id)->get();

        return $this->getModel()->with('comments')->where('user_id',$user_id)->get();
    }


}
