@extends('layouts.admin.app')
@section('content')
    <div class="container pt-4">
        <h1 class="mt-2">Add Tags</h1>
        {{-- <ol class="breadcrumb">
            <li class="breadcrumb-item active">add tags for questions</li>
            <!-- <li class="breadcrumb-item active">Dashboard</li> -->
        </ol> --}}
    </div>
    <div class="container">
        <a class="btn btn-primary" href="{{ route('tag.create') }}"> Add Tags </a>
        <ol class="breadcrumb mt-2">
            <li class="breadcrumb-item active">add tags for question's suggestions</li>
            <!-- <li class="breadcrumb-item active">Dashboard</li> -->
        </ol>
    </div>
    <div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tag List
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tags</th>
                        <th>Action</th>
                    </tr>
                </thead>
                @foreach ($tags as $tag)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td> <a class="flex--item s-tag" href="#">{{ $tag->tag }}</a></td>
                        <td>
                            <form action="{{ route('tag.destroy', $tag->id) }}" method="POST">
                                <a class="btn btn-primary" href="{{ route('tag.edit', $tag) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    {{ $tags->links() }}
@endsection
