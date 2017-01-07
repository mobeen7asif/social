@extends('master')

@section('content')
    @if(\Session::has('success'))
        <h4 class="alert alert-success fade in">
            {{\Session::get('success')}}
        </h4>
    @endif
    <section class="row posts">
        <div class="col-md-6 col-md-offset-3">
            <header id="user" data-owner="{{json_encode(['owner' => Auth::user()->first_name])}}"><h3>{{'Posts of '.$user}}</h3></header>
            @foreach($posts as $post)
                <article class="post" data-id="{{$post->id}}">
                    <p data-post="{{$post->body}}">{{ $post->body }}</p>
                    <div class="info">
                        Posted by {{$post->user->first_name}} on {{$post->created_at}}
                    </div>
                    <div class="interaction" >
                        <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You like this post' : 'Like' : 'Like'  }}</a> |
                        <a href="#" class="Dislike">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You don\'t like this post' : 'Dislike' : 'Dislike'  }}</a>
                        <a href="#" class="other" data-toggle="modal" data-target="#likes-modal" >Other likes</a>
                        @if(Auth::user() == $post->user)
                        |
                        <a href="#" class="edit" data-toggle="modal" data-target="#edit-modal" data-info="{{json_encode(['post' => $post->body])}}">Edit</a> |
                            <a href="{{url('/')}}/delete/{{$post->id}}" class="delete">Delete</a> |
                        @endif
                        <a href="#" class="comment" data-toggle="modal" data-target="#comment-modal">Comment</a>
                        <div class="{{$post->id}}" style="margin: 10px 0 0 20px;">
                            @foreach($post->comments as $comment)
                                <div class="comments-panel" style="margin: 10px 0 0 20px;" >
                                    <p>{{$comment->comment}}</p>
                                    <div class="info">
                                        Posted by <a href="{{url('/')}}/person/timeline/{{$comment->user->id}}">{{$comment->user->first_name}}</a>  on {{$comment->created_at}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Post</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="post-body">Edit the Post</label>
                            <textarea class="form-control" name="body" id="post" rows="5"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="comment-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Post</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="post-body">Post the comment</label>
                            <textarea class="form-control" name="body" id="comment" rows="5"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="comment-save">Post Comment</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="likes-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Post</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="post-body">People who like this post.</label>
                        </div>
                    </form>
                    <ul id="other-like"></ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script>
        var base_url = "http://localhost/social/public/";
        var postId = 0;
        var postBody = null;
        var otherLikesModal = null;
        var commentOwner = 's';

        $(".like").on('click',function(event){

            if($(this).text() == 'Like')
            {
                let likebtn = $(this);
                likebtn.text('You Like this');
                likebtn.next().text('Dislike');
                var post_id = likebtn.closest('article').attr('data-id');

                $.ajax({type: 'POST' , data: {'_token':"<?=csrf_token()?>" }, url: base_url + 'like/'+post_id ,
                    success: function (data){
                        var like = $.parseJSON(data);
                    }});
            }
        });


        $(".Dislike").on('click',function(event){

            if($(this).text() == 'Dislike') {

                let disLikebtn = $(this);
                disLikebtn.text('You Don\'t like this');
                disLikebtn.prev().text('Like');
                var post_id = disLikebtn.closest('article').attr('data-id');

                $.ajax({
                    type: 'POST', data: {'_token': "<?=csrf_token()?>"}, url: base_url + 'Dislike/' + post_id,
                    success: function (data) {
                        var like = $.parseJSON(data);
                        console.log(like);
                    }});
            }
        });

        $(document).on('click','.edit', function () {
            var modal = $("#edit-modal");
            var postData = JSON.parse($(this).attr('data-info'));
            modal.find('#post').text(postData.post);

            postId = $(this).closest('article').attr('data-id');

            postBody = $("article").find("p");
        });

        $(document).on('click','#modal-save', function () {

            var post = $('#post').val();
            $.ajax({
                type: 'POST', data: {'_token': "<?=csrf_token()?>" , 'post': post}, url: base_url + 'update/' + postId,
                success: function (data) {
                    var newPost = $.parseJSON(data);
                    console.log(newPost);
                    postBody.text(newPost['body']);
                    $('#edit-modal').modal('hide');
                }});

        });


        $(document).on('click','.comment', function () {

            postId = $(this).closest('article').attr('data-id');
            commentOwner = JSON.parse($("#user").attr('data-owner'));
            console.log(commentOwner);


        });

        $(document).on('click','#comment-save', function () {
            var comment = $('#comment').val();

            $.ajax({
                type: 'POST', data: {'_token': "<?=csrf_token()?>" , 'comment': comment}, url: base_url + 'comment/' + postId,
                success: function (data) {
                    var result = $.parseJSON(data);
                    console.log(result);
                    $('#comment-modal').modal('hide');



                    $('.'+postId).append(
                            $('<div>')
                                    .attr("class", "newDiv1")
                                    .addClass("newDiv purple bloated")
                                    .text(result.comment));

                    $('.'+postId).append('<div class="info">' +
                            'Posted by'+' '+commentOwner.owner+' '+'on'+' '+result.created_at
                            +'</div>');


                }});

        });


        $(document).on('click','.other', function () {
            postId = $(this).closest('article').attr('data-id');
            otherLikesModal = $('#likes-modal');
            $.ajax({
                type: 'GET', data: {'_token': "<?=csrf_token()?>"}, url: base_url + 'other/likes/' + postId,
                success: function (data) {
                    var likes = $.parseJSON(data);
                    console.log(likes);
                    for(var i = 0; i<likes.length; i++)
                    {
                        $('#other-like').append($('<ul>', {
                            text: likes[i].first_name
                        }));
                    }


                }});
        });

    </script>

@endsection