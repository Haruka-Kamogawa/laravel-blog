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
            <a href="{{ route('profile.edit') }}" class="text-decoration-none">Edit Profile</a>
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
                    <div class="col-8 d-flex flex-column">
                        <div class="mt-2 flex-grow-1">
                            <a href="{{ route('post.show', $post->id)}}">
                                <h3 class="h4">{{ $post->title }}</h3>
                            </a>

                            <div class="mt-3 mb-2">
                                <i class="fa-solid fa-calendar-days"></i>
                                &nbsp;
                                {{ $post->created_at->format('M d, Y') }}
                            </div>

                            @if (strlen($post->body) > 40)
                                {{ Str::limit($post->body, 40) }}
                                <a href="{{ route('post.show', $post->id) }}">More</a>
                            @else
                                {{ $post->body }}
                            @endif
                        </div>

                        @if (Auth::user()->id == $post->user_id)
                            <div class="mt-2 text-end">
                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>

                                <form action="{{ route('post.destroy', $post->id )}}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm">
                                        <i class="fa-solid fa-trash-can"></i> Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </ul>
    @endif
@endsection