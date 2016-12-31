<?php

namespace App\Http\Controllers;

use App\Post;
use App\Repositories\CommentsRepository;
use App\Repositories\LikesRepository;
use App\Repositories\PostsRepository;
use App\Repositories\UsersRepository;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

    private $usersRepo = null;
    private $postRepo = null;
    private $likesRepo = null;
    private $commentsRepo = null;
    public function __construct(UsersRepository $usersRepo, PostsRepository $postRepo ,LikesRepository $likesRepo, CommentsRepository $commentsRepo)
    {
        $this->usersRepo = $usersRepo;
        $this->postRepo = $postRepo;
        $this->likesRepo = $likesRepo;
        $this->commentsRepo = $commentsRepo;
    }

    public function postComment(Request $request)
    {
        $post_id = $request->route()->parameter('postId');
        $comment = $request->input('comment');
        $data = $this->commentsRepo->store([
            'user_id' => Auth::user()->id,
            'post_id' => $post_id,
            'comment' => $comment
        ]);

        echo json_encode($data);
    }

}