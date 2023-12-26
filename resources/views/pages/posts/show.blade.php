@extends('layouts.default')

@section('title', $post->title)

@push('style')
@endpush

@push('script')
@endpush

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2 font-weight-bold text-dark">{{ $post->title }}</h1>
                            <div class="lead">
                                <a href="{{ route('posts.list') . '?category=' . $post->category }}">{{ $post->category }}</a>
                                <div class="bullet mx-2"></div>
                                <span>{{ $post->created_at }}</span>
                            </div>
                            <img src="{{ asset('storage/posts/' . $post->thumbnail) }}" alt="" class="img-fluid w-100 mt-4 mb-4">
                            <div class="lead">
                                {!! $post->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
