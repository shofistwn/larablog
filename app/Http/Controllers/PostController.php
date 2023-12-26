<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->all();
            $posts = $this->postService->getPosts($filters);
            return view('pages.posts.index', compact('posts'));
        } catch (\Exception $e) {
            return redirect()->route('posts.index')->with('error', $e->getMessage());
        }
    }

    public function list(Request $request)
    {
        try {
            $filters = array_merge($request->all(), ['status' => 'Publish']);
            $limit = 12;
            $posts = $this->postService->getPosts($filters, $limit);
            return view('pages.posts.list', compact('posts'));
        } catch (\Exception $e) {
            return redirect()->route('posts.list')->with('error', $e->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            $post = $this->postService->findPostPublish($id);
            return view('pages.posts.show', compact('post'));
        } catch (\Exception $e) {
            return redirect()->route('posts.index')->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('pages.posts.create');
    }

    public function store(PostRequest $request)
    {
        try {
            $this->postService->createPost($request->all());
            return redirect()->route('posts.index')->with('success', 'Post created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('posts.create')->with('error', $e->getMessage());
        }
    }

    public function edit(int $id)
    {
        try {
            $post = $this->postService->findPost($id);
            return view('pages.posts.edit', compact('post'));
        } catch (\Exception $e) {
            return redirect()->route('posts.index')->with('error', $e->getMessage());
        }
    }

    public function update(int $id, PostRequest $request)
    {
        try {
            $this->postService->updatePost($id, $request->all());
            return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('posts.edit', $id)->with('error', $e->getMessage());
        }
    }

    public function trash(int $id)
    {
        try {
            $this->postService->deletePost($id);
            return redirect()->route('posts.index')->with('success', 'Post trashed successfully!');
        } catch (\Exception $e) {
            return redirect()->route('posts.index')->with('error', $e->getMessage());
        }
    }

    public function restore(int $id)
    {
        try {
            $this->postService->restorePost($id);
            return redirect()->route('posts.index')->with('success', 'Post restored successfully!');
        } catch (\Exception $e) {
            return redirect()->route('posts.index')->with('error', $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $this->postService->deletePostPermanently($id);
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('posts.index')->with('error', $e->getMessage());
        }
    }
}
