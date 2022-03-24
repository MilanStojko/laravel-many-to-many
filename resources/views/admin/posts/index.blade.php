@extends('layouts.app')

@section('content')
    <a href="{{ route('admin.posts.create') }}"><button type="button" class="btn btn-success">aggiungi</button></a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">title</th>
                <th scope="col">content</th>
                <th scope="col">categoria</th>
                <th scope="col">tags</th>
                <th scope="col">slug</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{ $post->title }}</th>
                    <td>{{ $post->content }}</th>
                    <td>{{ $post->category ? $post->category->name : '-' }}</td>
                    <td>
                        @if ($post->tags->isNotEmpty())
                            @foreach ($post->tags as $tag)
                                <i>{{ $tag->name }}</i>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $post->slug }}</th>
                    <td>
                        <a href="{{ route('admin.posts.show', $post->id) }}"><button type="button"
                                class="btn btn-primary">vedi</button></a>
                        <a href="{{ route('admin.posts.edit', $post->id) }}"><button type="button"
                                class="btn btn-warning">edit</button></a>
                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-danger">delete</button>
                        </form>
                        </th>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
