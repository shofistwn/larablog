@extends('layouts.default')

@section('title', 'Edit Post')

@push('style')
    <link rel="stylesheet" href="{{ asset('modules/summernote/summernote-bs4.css') }}">
@endpush

@push('script')
    <script src="{{ asset('modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>

    <script src="{{ asset('js/page/features-post-create.js') }}"></script>

    <script>
        $(".summernote-simple").summernote({
            dialogsInBody: true,
            minHeight: 150,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['para', ['paragraph']],
                ['style', ['style']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'hr']],
                ['heading', ['style', 'ol', 'ul', 'paragraph']],
                ['misc', ['fullscreen', 'codeview']],
            ],
            callbacks: {
                onInit: function() {
                    $(".summernote-simple").summernote('code', '{!! old('content', $post->content) !!}');
                }
            }
        });
    </script>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('posts.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit Post</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></div>
                <div class="breadcrumb-item">Edit Post</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Edit Post</h2>
            <p class="section-lead">
                On this page you can edit a post.
            </p>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Your Post</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('posts.update', $post->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            name="title" value="{{ old('title', $post->title) }}">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select
                                            class="form-control @error('category') is-invalid border border-danger @enderror selectric"
                                            name="category">
                                            <option @selected(old('category', $post->category) == 'Tech')>Tech</option>
                                            <option @selected(old('category', $post->category) == 'News')>News</option>
                                            <option @selected(old('category', $post->category) == 'Political')>Political</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                                    <div class="col-sm-12 col-md-7">
                                        <textarea class="summernote-simple form-control @error('content') is-invalid border border-danger @enderror"
                                            name="content"></textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                                    <div class="col-sm-12 col-md-7">
                                        <div id="image-preview" class="image-preview"
                                            style="background-image: url('{{ asset('storage/posts/' . $post->thumbnail) }}'); background-size: cover; background-position: center center">
                                            <label for="image-upload" id="image-label">Choose File</label>
                                            <input type="file" name="thumbnail" id="image-upload" readonly />
                                        </div>
                                        @error('thumbnail')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select
                                            class="form-control @error('status') is-invalid border border-danger @enderror selectric"
                                            name="status">
                                            <option @selected(old('status', $post->status) == 'Publish')>Publish</option>
                                            <option @selected(old('status', $post->status) == 'Draft')>Draft</option>
                                            <option @selected(old('status', $post->status) == 'Pending')>Pending</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button type="submit" class="btn btn-primary">Edit Post</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
