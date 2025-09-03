@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @forelse ($all_posts as $post)
        <div class="row border border-2 rounded mb-3 p-4 animate__animated animate__fadeIn">
            <div class="col-4">
                @if ($post->image)
                    <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="w-100 img-thumbnail" style="height:200px; object-fit:cover;">
                @else
                    <i class="fa-solid fa-image fa-10x d-block text-center"></i>
                @endif
            </div>
            <div class="col-8 d-flex flex-column">
                <div class="mt-2 flex-grow-1">
                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none text-dark">
                        <h2 class="h4">{{ $post->title }}</h2>
                    </a>
                    {{--                             model->user() method inside Post.php --}}
                    <h3 class="h6 text-secondary py-2">
                        <a href="{{ route('profile.specificShow', $post->user->id) }}"  class="text-decoration-none text-dark">
                            <i class="fa-solid fa-user"></i>
                            &nbsp;
                            {{ $post->user->name }}
                        </a>
                        &nbsp; 
                        &nbsp;
                        |
                        &nbsp; 
                        &nbsp;
                        <i class="fa-solid fa-calendar-days"></i>
                        &nbsp;
                        {{ $post->created_at->format('M d, Y') }}
                    </h3>
                    <p class="fw-lignt mb-0">
                        @if (strlen($post->body) > 40)
                            {{ Str::limit($post->body, 40) }}
                            <a href="{{ route('post.show', $post->id) }}">More</a>
                        @else
                            {{ $post->body }}
                        @endif
                    </p>
                </div>

                {{-- Action Buttons --}}
                {{-- logged in user == user_id column(owner) --}}
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

    @empty
        <div class="text-center" style="margin-top: 100px">
            <h2 class="text-secondary">No Posts Yet</h2>
            <a href="{{ route('post.create') }}" class="text-decoration-none">Create a new post</a>
        </div>
    @endforelse

    {{-- ページネーションリンク --}}
    <div class="d-flex float-end mt-4">
        {{ $all_posts->links('pagination::bootstrap-5') }}
    </div>
@endsection