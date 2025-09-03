@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    {{-- input type="file"　を使うなら enctype="multipart/form-data" が必要 --}}
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label text-secondary">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Enter title here" autofocus>

            {{-- Error --}}
            @error('title')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

        </div>
        <div class="mb-3">
            <label for="body" class="form-label text-secondary">Body</label>
            <textarea name="body" id="body" rows="5" class="form-control" placeholder="Stert writing...">{{ old('body') }}</textarea>

            {{-- Error --}}
            @error('body')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

        </div>
        <div class="mb-3">
            <label for="image" class="form-label text-secondary">Image</label>
            <input type="file" name="image" id="image" class="form-control" aria-describedat="image-info">
            <div class="form-text" id="image-info">
                Acceptable formats are jpeg, jpg, png, gif only.<br>
                Maximum file size is 1048kB.
            </div>

            {{-- Error --}}
            @error('image')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

        </div>

        <button type="submit" class="btn btn-primary px-5">Post</button>
    </form>
@endsection