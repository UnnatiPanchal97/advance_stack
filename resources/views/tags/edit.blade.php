@extends('layouts.admin.app')
@section('content')
<style>
    label.error {
        color: #dc3545;
        font-size: 20px;
    }
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Tags</h1>
    <ol class="breadcrumb mb-4">
        <a class="btn btn-primary" href="{{ route('tag.index') }}"> Back</a>
    </ol>
    <form id="edittagForm" action="{{ route('tag.update',$tag->id) }}" method="POST">
        {{-- {{ route('tag.update',$tag->id) }} --}}
        @csrf
        @method('PUT')
        {{-- {{ dd($tag) }} --}}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <div class="form-group">
                    <label for="tag">
                        <strong>Tags<span class="text-danger">*</span></strong>
                    </label>
                    <input type="text" id="tags" name="tag" class="form-control" placeholder="Enter Tag"
                        value="{{ $tag->tag }}">
                    @if ($errors->has('tag'))
                    <span class="text-danger">{{ $errors->first('tag') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
    </form>
</div>
<!-- <script src="{{ asset('Jquery/crud_validation.js') }}?t={{ time() }}"></script> -->
@endsection