<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
  protected $postModel;

  public function __construct(Post $postModel)
  {
    $this->postModel = $postModel;
  }

  public function get(array $filters, int $limit)
  {
    $query = $this->postModel->query();

    foreach ($filters as $field => $value) {
      switch ($field) {
        case 'title':
        case 'category':
          $query->where($field, 'like', '%' . $value . '%');
          break;

        case 'status':
          if ($value == 'Trash') {
            $query->onlyTrashed();
          } else {
            $query->where($field, $value);
          }
          break;

        default:
          break;
      }
    }

    return $query->latest()->paginate($limit);
  }

  public function find(int $id)
  {
    return $this->postModel->findOrFail($id);
  }

  public function findPublish(int $id)
  {
    return $this->postModel->where('status', 'Publish')->findOrFail($id);
  }

  public function findTrashed(int $id)
  {
    return $this->postModel->onlyTrashed()->findOrFail($id);
  }

  public function create(array $data)
  {
    return $this->postModel->create($data);
  }

  public function update(int $id, array $data)
  {
    $post = $this->find($id);
    return $post->update($data);
  }

  public function delete(int $id)
  {
    $post = $this->find($id);
    return $post->delete();
  }

  public function restore(int $id)
  {
    $post = $this->findTrashed($id);
    return $post->restore();
  }

  public function forceDelete(int $id)
  {
    $post = $this->findTrashed($id);
    return $post->forceDelete();
  }
}