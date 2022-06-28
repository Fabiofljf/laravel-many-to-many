@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between py-4">
        <h1>All Posts</h1>
        <div><a href="{{route('admin.posts.create')}}" class="btn btn-primary">Add Post</a></div>
    </div>

    @include('partials.session_message')
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Cover Image</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($posts as $post)
            <tr>
                <td scope="row">{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td>{{$post->slug}}</td>
                <td><img width="150" src="{{$post->cover_image}}" alt="Cover image {{$post->title}}"></td>
                <td>
                    <a class="btn btn-primary text-white btn-sm" href="{{route('admin.posts.show', $post->slug)}}">View</a>
                    <a class="btn btn-secondary text-white btn-sm" href="{{route('admin.posts.edit', $post->slug)}}">Edit</a>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                        Delete
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="delete-post-{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitle-{{$post->id}}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete current</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this post?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>


                                    <form action="{{route('admin.posts.destroy', $post->slug)}}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>



                </td>
            </tr>

            @empty
            <tr>
                <td scope="row">No Posts! Create your first post <a href="#">Create post</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>


</div>
@endsection
