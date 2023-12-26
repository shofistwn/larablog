<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Helpers\FileHelper;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PostService
{
  protected $postRepository;

  public function __construct(PostRepository $postRepository)
  {
    $this->postRepository = $postRepository;
  }

  public function getPosts(array $filters, int $limit = 6)
  {
    return $this->postRepository->get($filters, $limit);
  }

  public function findPost(int $id)
  {
    try {
      return $this->postRepository->find($id);
    } catch (ModelNotFoundException $e) {
      throw new Exception($e->getMessage(), 404, $e);
    }
  }

  public function findPostPublish(int $id)
  {
    try {
      return $this->postRepository->findPublish($id);
    } catch (ModelNotFoundException $e) {
      throw new Exception($e->getMessage(), 404, $e);
    }
  }

  public function createPost(array $data)
  {
    DB::beginTransaction();

    try {
      FileHelper::uploadThumbnail($data);

      $postData = [
        'title' => $data['title'],
        'category' => $data['category'],
        'content' => $data['content'],
        'status' => $data['status'],
      ];

      if (isset($data['thumbnail'])) {
        $postData['thumbnail'] = $data['thumbnail'];
      }

      $post = $this->postRepository->create($postData);

      DB::commit();
      return $post;
    } catch (QueryException $e) {
      DB::rollBack();
      throw new Exception('Error creating post: ' . $e->getMessage(), 500, $e);
    } catch (Exception $e) {
      DB::rollBack();
      throw new Exception($e->getMessage(), 500, $e);
    }
  }

  public function updatePost(int $id, array $data)
  {
    DB::beginTransaction();

    try {
      $post = $this->postRepository->find($id);
      FileHelper::uploadThumbnail($data, $post);

      $post = $this->postRepository->update($id, [
        'title' => $data['title'],
        'category' => $data['category'],
        'content' => $data['content'],
        'status' => $data['status'],
        'thumbnail' => $data['thumbnail'],
      ]);

      DB::commit();
      return $post;
    } catch (QueryException $e) {
      DB::rollBack();
      throw new Exception('Error updating post: ' . $e->getMessage(), 500, $e);
    } catch (Exception $e) {
      DB::rollBack();
      throw new Exception($e->getMessage(), 500, $e);
    }
  }

  public function deletePost(int $id)
  {
    DB::beginTransaction();

    try {
      $post = $this->postRepository->delete($id);

      DB::commit();
      return $post;
    } catch (Exception $e) {
      DB::rollBack();
      throw new Exception($e->getMessage(), 500, $e);
    }
  }

  public function restorePost(int $id)
  {
    DB::beginTransaction();

    try {
      $post = $this->postRepository->restore($id);

      DB::commit();
      return $post;
    } catch (Exception $e) {
      DB::rollBack();
      throw new Exception($e->getMessage(), 500, $e);
    }
  }

  public function deletePostPermanently(int $id)
  {
    DB::beginTransaction();

    try {
      $post = $this->postRepository->findTrashed($id);

      if ($post) {
        FileHelper::deleteThumbnail($post->thumbnail);
      }

      $post = $this->postRepository->forceDelete($id);

      DB::commit();
      return $post;
    } catch (Exception $e) {
      DB::rollBack();
      throw new Exception($e->getMessage(), 500, $e);
    }
  }
}