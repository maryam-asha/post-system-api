<?php

namespace App\Service;

use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostService
{
    /**
     * Retrieve paginated list of posts.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function list()
    {
        try {
            return Post::latest()->paginate(5);
        } catch (\Exception $e) {
            throw new \Exception('Unable to fetch posts');
        }
    }

    /**
     * Create a new post.
     *
     * @param array $data
     * @return Post
     */
    public function store(array $data): Post
    {


            return Post::create($data);
        
    }


    /**
     * Find a post by ID.
     *
     * @param post $post
     * @return Post
     * @throws ModelNotFoundException
     */
    public function find(Post $post): Post
    {
        return $post;
        // try {
        //     return Post::findOrFail($id);
        // } catch (ModelNotFoundException $e) {
        //     throw new ModelNotFoundException('Post not found');
        // }
    }


    /**
     * Update an existing post.
     *
     * @param Post $post
     * @param array $data
     * @return Post
     */
    public function update(Post $post, array $data): Post
    {
        try {
            $post->update($data);
            return $post;
        } catch (\Exception $e) {
            throw new \Exception('Unable to update post');
        }
    }

    /**
     * Delete a post.
     *
     * @param Post $post
     * @return bool
     */
    public function delete(Post $post): bool
    {
        try {
            return $post->delete();
        } catch (\Exception $e) {
            throw new \Exception('Unable to delete post');
        }
    }
}
