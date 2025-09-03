@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
    <div class="mt-2 border border-2rounded p-4 shadow-sm">
        <h2 class="h4">{{ $post->title }}</h2>
        {{--                             model->user() method inside Post.php --}}
        <a href="{{ route('profile.specificShow', $post->user->id) }}"  class="text-decoration-none text-secondary h6">
            {{ $post->user->name }}
        </a>
        <p class="fw-lignt">{{ $post->body }}</p>

        <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="w-100 shadow rounded">
        {{-- asset() helper is used to access the public directory --}}
    </div>

    <form action="{{ route('comment.store', $post->id) }}" method="post">
        @csrf


        <div class="card mt-5">
            <div class="card-body">
                <div class="input-group">
                    <img src="{{ asset('storage/avatar/' . $post->user->avatar) }}" alt="{{ $post->user->avatar }}" class="rounded-circle" style="objuct-fit: cover; width: 35px; height:35px;">

                    <input type="text" name="comment" class="form-control ms-5" placeholder="Add a comment...">
                    <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
                </div>
            </div>
        </div>

        {{-- Error --}}
        @error('comment')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </form>

    {{-- If the post has comments, show the comments --}}
    @if ($post->comments)
        <div class="my-2 mb-5">
            @foreach ($post->comments as $comment)
                <div class="row p-2">
                    <div class="col-10">
                        <img src="{{ asset('storage/avatar/' . $post->user->avatar) }}" alt="{{ $post->user->avatar }}" class="rounded-circle" style="objuct-fit: cover; width: 35px; height:35px;">
                        <a href="{{ route('profile.specificShow', $comment->user->id) }}" class="text-decoration-none text-black">
                            <span class="fw-bold">{{ $comment->user->name }}</span>
                        </a>
                        &nbsp;
                        {{-- non-breaking space --}}
                        <span class="small text-muted">{{ $comment->created_at }}</span>
                        <p class="mb-0">{{ $comment->body }}</p>
                    </div>
                    <div class="col-2 text-end">
                        {{-- show a Delete button if the Auth is the owner of the comment --}}
                        @if ($comment->user_id === Auth::user()->id)
                            <button type="button" class="btn text-primary btn-md" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $comment->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        
                            <form action="{{ route('comment.destroy', $comment->id)}}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn text-danger btn-md">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="modal fade" id="exampleModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="exampleModalLabel-{{ $comment->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content container">
                            <div class="modal-header">
                                <h1 class="modal-title text-center h3" id="exampleModalLabel"><i class="fa-solid fa-comment"></i> Edit Comment</h1>

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>    
                            </div>

                            <form action="{{ route('comment.update', $comment->id)}}" method="post">
                                @csrf
                                @method('PATCH')

                                <div class="modal-body">
                                    <div class="row mb-3 mt-3">
                                        <div class="col">
                                            <label for="comment" class="form-label">Write here</label>
                                            <input type="text" name="comment" id="comment" class="form-control" value="{{ $comment->body }}">

                                            @error('comment')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-pen"></i> Save</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    @endif
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

@endsection