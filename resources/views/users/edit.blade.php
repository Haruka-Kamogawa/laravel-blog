@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mt-3 mb-3 text-center">
                    {{-- display avatar --}}
                    @if ($user->avatar)
                        <img src="{{ asset('storage/avatar/' . $user->avatar) }}" alt="{{ $user->avatar }}" class="rounded-circle img-thumbnail" style="object-fit: cover; width: 200px; height: 200px;">
                    @else
                        <i class="fa-solid fa-image fa-10x d-block text-center"></i>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="avatar" class="form-label text-secondary">Upload New Avatar</label>
                    <input type="file" name="avatar" id="avatar" class="form-control" aria-describedat="image-info">
                    <div class="form-text" id="image-info">
                        <i class="fa-solid fa-circle-info text-primary"></i> Acceptable formats: <span class="fw-bold">jpeg, jpg, png, gif</span><br>
                        <i class="fa-solid fa-circle-exclamation text-danger"></i> Max file size: <span class="fw-bold">1048kB</span>
                    </div>

                    {{-- Error --}}
                    @error('avatar')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="name" class="form-label text-secondary">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">

                    {{-- Error --}}
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label text-secondary">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">

                    {{-- Error --}}
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label text-secondary">Password</label>
                    <input type="password" name="password" id="password" class="form-control" value="" required>

                    {{-- Error --}}
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <a href="{{ route('profile.show')}}" class="btn btn-secondary px-5">Cancel</a>
                    <button type="submit" class="btn btn-warning px-5">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection