@extends('layouts.admin')


@section('content')

<div class="posts d-flex py-4">
    <img class="img-fluid" src="{{$post->cover_image}}" alt="{{$post->title}}">

    <div class="post-data px-4">
        <h1>{{$post->title}}</h1>
        <div class="metadata">
            <div class="category">
                <strong>Category:</strong> {{$post->category ? $post->category->name : 'Uncategorized'}}
            </div>
            <div class="tags">
                <strong>Tags</strong>
                @if (count($post->tags) > 0)
                @foreach ($post->tags as $tag )
                <span>#{{$tag->name}} </span>
                @endforeach
                @else
                <span>N/A</span>

                @endif
            </div>

        </div>
        <div class="content">
            {{$post->content}}
        </div>
    </div>
</div>


@endsection
