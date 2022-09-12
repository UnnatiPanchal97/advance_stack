@extends('layouts.admin.app')
@section('content')
    <div class="container pt-4">
        <h1 class="mt-4">Ask Public Questions</h1>
        <ol class="breadcrumb mb-4">
            <a class="btn btn-primary" href="{{ url('/') }}"> Back</a>
        </ol>
        <div class="card">
            <form action=" {{ route('question.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="title"><strong>Title <span class="text-danger">*</span></strong></label>
                            <input type="text" id="title" name="title" class="form-control"
                                placeholder="Enter Title">
                            @if ($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="body"><strong>Body <span class="text-danger">*</span></strong></label>
                            <textarea class="ckeditor form-control" name="body" required></textarea>
                            @if ($errors->has('body'))
                                <span class="text-danger">{{ $errors->first('body') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- dd($tags) --}}
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="question_tag"><strong>Select Tags <span
                                        class="text-danger">*</span></strong></label>
                            <select class="js-example-basic-multiple o100 form-control" name="question_tag[]"
                                multiple="multiple">
                                <option class="o100" value="" disabled>Select tag</option>
                                @foreach ($tags as $tag)
                                    <option class="fc-black-900" value="{{ $tag->tag }}">{{ $tag->tag }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('question_tag'))
                                <span class="text-danger">{{ $errors->first('question_tag') }}</span>
                            @endif
                            <ol class="breadcrumb h16 pt-0 pl-1">
                                Select tags according to your question.
                            </ol>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Review Your Question</button>
        </div>
        </form>
    </div>
    @endsection
    @section('footer-scripts')
    {{-- --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
                // $('.ckeditor');
        });
    </script>
    @endsection