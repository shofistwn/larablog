@extends('layouts.default')

@section('title', 'Posts')

@push('style')
@endpush

@push('script')
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Posts</h1>
        </div>
        <div class="section-body">
            <div class="row justify-content-center">
                @forelse ($posts as $post)
                    <div class="col-12 col-md-4 col-lg-3">
                        <article class="article article-style-c">
                            <div class="article-header">
                                <div class="article-image" data-background="{{ asset('storage/posts/' . $post->thumbnail) }}">
                                </div>
                            </div>
                            <div class="article-details">
                                <div class="article-category">
                                    <a
                                        href="{{ route('posts.list') . '?category=' . $post->category }}">{{ $post->category }}</a>
                                    <div class="bullet"></div>
                                    <a>{{ $post->created_at }}</a>
                                </div>
                                <h2 class="font-weight-bold mb-0" style="font-size: 1.5rem"><a
                                        href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
                            </div>
                        </article>
                    </div>
                @empty
                    <p class="text-center">Post not found</p>
                @endforelse

                <div class="col-12">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
