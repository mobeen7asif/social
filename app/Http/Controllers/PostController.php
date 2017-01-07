<?php

namespace App\Http\Controllers;

use App\Post;
use App\Repositories\LikesRepository;
use App\Repositories\PostsRepository;
use App\Repositories\UsersRepository;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{

    private $usersRepo = null;
    private $postRepo = null;
    private $likesRepo = null;
    public function __construct(UsersRepository $usersRepo, PostsRepository $postRepo ,LikesRepository $likesRepo)
    {
        $this->usersRepo = $usersRepo;
        $this->postRepo = $postRepo;
        $this->likesRepo = $likesRepo;
    }

    public function getDashboard()
    {
        $posts = $this->postRepo->getPosts();
//        return $posts;
        return view('dashboard' , ['posts' => $posts]);
    }

    public function postCreatePost(Requests\Post\CreatePostRequest $request)
    {

//        $post = new Post();
//        $post->body = $request->input('body');
//        $request->user()->posts()->save($post);

        $this->postRepo->store(['body' => $request->input('body') , 'user_id' => Auth::user()->id]);
        return redirect()->route('dashboard')->with(['success' => 'Post Created Successfully']);
    }

    public function postUpdatePost(Requests\Post\EditPostRequest $request)
    {
        $post_id = $request->route()->parameter('postId');
        $newPost = $request->input('post');
        $this->postRepo->updateWhere(['id' => $post_id] , ['body' => $newPost]);
        $data = $this->postRepo->findById($post_id);


        echo json_encode($data);
    }

    public function postDeletePost(Requests\Post\DeletePostRequest $request)
    {
        $post_id = $request->route()->parameter('postId');
        $this->postRepo->deleteById($post_id);
        return redirect()->route('dashboard')->with(['success' => 'Post Deleted Successfully']);
    }

    public function getAllPosts(Requests\Post\AllPostsRequest $request)
    {
        return $this->postRepo->getPosts();

    }

    public function like(Requests\Post\LikeRequest $request)
    {
        $post_id = $request->route()->parameter('post_id');
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if($like)
        {
            $data = $this->likesRepo->updateWhere(['post_id' => $post_id] , [ 'like' => 1]);
            echo json_encode($data);
        }
        else{
            $data = $this->likesRepo->store(['user_id' =>Auth::user()->id , 'post_id' => $post_id, 'like' => 1]);
            echo json_encode($data);
        }

    }

    public function Dislike(Requests\Post\LikeRequest $request)
    {
        $post_id = $request->route()->parameter('post_id');
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if($like)
        {
            $data = $this->likesRepo->updateWhere(['post_id' => $post_id] , [ 'like' => 0]);
            echo json_encode($data);

        }
        else{
            $data = $this->likesRepo->store(['user_id' =>Auth::user()->id , 'post_id' => $post_id, 'like' => 0]);
            echo json_encode($data);
        }
    }

    public function getLikes(Requests\Post\OtherLikes $request)
    {

        $post_id = $request->route()->parameter('postId');
        $data = $this->likesRepo->get_likes($post_id);
        echo json_encode($data);
    }


    public function getPersonTimeline(Request $request)
    {
        $user_id = $request->route()->parameter('user_id');
        $user = $this->usersRepo->findById($user_id);
        $posts = $this->postRepo->getPersonPosts($user_id);

        return view('person-timeline', ['posts' => $posts] , ['user' => $user->first_name]);

    }




}