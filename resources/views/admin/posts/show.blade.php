@extends('layouts.app')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{!! $post->content !!}</p>
    <p>{{ $post->slug }}</p>
    <p> Categoria : {{ $post->category ? $post->category->name : '-' }}</p>
    <p> Tags :
        @if ($post->tags->isNotEmpty())
            @foreach ($post->tags as $tag)
                <i>{{ $tag->name }}</i>
            @endforeach
        @else
            -
        @endif
    </p>

    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
        @csrf
        @method("DELETE")
        <button type="submit" class="btn btn-danger" onclick='return confirm("va che poi non cè più")'>Eutanizza</button>
    </form>

    <a href="{{ route('admin.posts.index') }}"><button type="button" class="btn btn-primary">back</button></a>
@endsection
