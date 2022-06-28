@extends('layouts.admin')


@section('content')




@include('partials.session_message')
@include('partials.errors')

<div class="container">
    <h1 class="my-3">All Tags</h1>
    <div class="row">
        <div class="col pe-5">
            <form action="" method="post" class="d-flex align-items-center">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="
                    Add a tag name here " aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Add</button>
                </div>
            </form>
        </div>
        <div class="col">

            <table class="table table-striped table-inverse table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Posts Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tags as $tag)
                    <tr>
                        <td scope="row">{{$tag->id}}</td>
                        <td>
                            <form id="tag-{{$tag->id}}" action="{{route('admin.tags.update', $tag->slug)}}" method="post">
                                @csrf
                                @method('PATCH')
                                <input class="border-0 bg-transparent" type="text" name="name" value="{{$tag->name}}">
                            </form>

                        </td>
                        <td>{{$tag->slug}}</td>
                        <td><span class="badge badge-info bg-dark">{{count($tag->posts)}}</span></td>
                        <td>
                            <button form="tag-{{$tag->id}}" type="submit" class="btn btn-primary">Update</button>
                            <form action="{{route('admin.tags.destroy', $tag->slug)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger text-white">Delete</button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td scope="row">No tags! Add your first tag.</td>

                    </tr>
                    @endforelse
                </tbody>
            </table>


        </div>

    </div>
</div>


@endsection
