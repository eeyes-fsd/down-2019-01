<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\User;
use App\Http\Requests\CommentRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserComments as CommentsResource;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 返回所有用户及其评论
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Comment::class);

        $users = User::has('comments')->paginate(20);

        return CommentsResource::collection($users);
    }

    /**
     * 查看某一用户的全部评论
     *
     * @param User $user
     * @return CommentsResource
     */
    public function show(User $user)
    {
        $this->authorizeResource(Comment::class, $user);

        return new CommentsResource($user);
    }

    /**
     * 存储用户评论
     *
     * @param CommentRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $data = $request->only(['user_id', 'content']);

        $data['admin'] = Auth::id() == 1;

        Comment::create($data);

        return response(null, 201);
    }

    /**
     * 删除评论
     *
     * @param Comment $comment
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        return response();
    }
}
