@extends('layouts.default')

@section('title', 'Posts')

@push('style')
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var statusParam = urlParams.get('status');

            $('.nav-pills .nav-link').removeClass('active');
            if (!statusParam || statusParam === 'all') {
                $('.nav-pills a[data-status="all"]').addClass('active');
            } else {
                $('.nav-pills a[data-status="' + statusParam + '"]').addClass('active');
            }
        });
    </script>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Posts</h1>
            <div class="section-header-button">
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></div>
                <div class="breadcrumb-item">All Posts</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Posts</h2>
            <p class="section-lead">
                You can manage all posts, such as editing, deleting and more.
            </p>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts.index') }}" data-status="all">All</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts.index') . '?status=Draft' }}"
                                        data-status="Draft">Draft</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts.index') . '?status=Pending' }}"
                                        data-status="Pending">Pending</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts.index') . '?status=Trash' }}"
                                        data-status="Trash">Trash</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Posts</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right">
                                <form action="{{ route('posts.index') }}" method="get">

                                    <div class="input-group">
                                        <input type="text" class="form-control" name="title" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                    </tr>
                                    @forelse ($posts as $post)
                                        <tr>
                                            <td>{{ $post->title }}
                                                <div class="table-links">
                                                    @if (is_null($post->deleted_at))
                                                        @if ($post->status === 'Publish')
                                                            <a href="{{ route('posts.show', $post->id) }}" target="_blank">View</a>
                                                            <div class="bullet"></div>
                                                        @endif
                                                        <a href="{{ route('posts.edit', $post->id) }}">Edit</a>
                                                        <div class="bullet"></div>
                                                        <a href="{{ route('posts.trash', $post->id) }}" class="text-danger"
                                                            onclick="return confirm('Are you sure you want to move this post to trash?')">Trash</a>
                                                    @else
                                                        <a href="{{ route('posts.restore', $post->id) }}"
                                                            class="text-warning"
                                                            onclick="return confirm('Are you sure you want to restore this post?')">Restore</a>
                                                        <div class="bullet"></div>
                                                        <a href="{{ route('posts.delete', $post->id) }}"
                                                            class="text-danger"
                                                            onclick="return confirm('Are you sure you want to delete this post permanenly?')">Delete</a>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('posts.index') . '?category=' . $post->category }}">{{ $post->category }}</a>
                                            </td>
                                            <td>{{ $post->created_at }}</td>
                                            <td>
                                                @if ($post->status === 'Publish')
                                                    <div class="badge badge-primary">Publish</div>
                                                @elseif ($post->status === 'Draft')
                                                    <div class="badge badge-secondary">Draft</div>
                                                @else
                                                    <div class="badge badge-warning">Pending</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Post not found</td>
                                        </tr>
                                    @endforelse
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $posts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
