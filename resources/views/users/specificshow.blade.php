@extends('layouts.app')

@section('title', '$user->name')

@section('content')
    <div class="row mb-5">
        <div class="col-4">
            @if ($user->avatar)
                <img src="{{ asset('storage/avatar/' . $user->avatar) }}" alt="{{ $user->avatar }}" class="w-100 img-thumbnail">
            @else
                <i class="fa-solid fa-image fa-10x d-block text-center"></i>
            @endif
        </div>
        <div class="col-8">
            <h2 class="display-6">{{ $user->name }}</h2>
        </div>
    </div>

    {{-- Display all posts created by the logged in user --}}
    @if ($user->posts)
        <ul class="list-group">
            @foreach ($user->posts as $post)
                <div class="row border border-2rounded mb-3 p-4">
                    <div class="col-4">
                        @if ($post->image)
                        <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="w-100 img-thumbnail" style="height:200px; object-fit:cover;">
                        @else
                        <i class="fa-solid fa-image fa-10x d-block text-center"></i>
                        @endif
                    </div>
                    <div class="col-8">
                        <div class="mt-2">
                            <a href="{{ route('post.show', $post->id)}}">
                                <h3 class="h4">{{ $post->title }}</h3>
                            </a>
                            <p class="fw-light mb-0">{{ $post->body }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    @endif
@endsection