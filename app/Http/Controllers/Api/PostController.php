<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Service\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{

    public function __construct(protected PostService $postService) {}
   /**
     * Display a listing of posts.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $posts= $this->postService->list();
        return response()->json([
            'status' => 'success',
            'data' =>PostResource::collection($posts),
            'message' => 'Posts retrieved successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created post.
     *
     * @param StorePostRequest $request
     * @return JsonResponse
     */
    public function store(StorePostRequest $request): JsonResponse
    {


        $post = $this->postService->store($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => new PostResource($post),
            'message' => 'Post created successfully',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified post.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(Post $post)
    {
        $post = $this->postService->find($post);
            return response()->json([
                'status' => 'success',
                'data' => new PostResource($post),
                'message' => 'Post retrieved successfully',
            ], Response::HTTP_OK);
    }

    /**
     * Update the specified post.
     *
     * @param UpdatePostRequest $request
     * @param post $post
     * @return JsonResponse
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {

        $post = $this->postService->update($post,$request->validated());
        return response()->json([
            'status' => 'success',
            'data' => new PostResource($post),
            'message' => 'Post updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified post.
     *
     * @param post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->postService->delete($post);
        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully',
        ], Response::HTTP_NO_CONTENT);
    }
}
