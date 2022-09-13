@extends('layouts.admin.app')
@section('content')
    @if ($message = Session::get('success'))
        <div>
            <div class="alert alert-success mt-3">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif
    <div class="container">
        <h1 class="pt-2">All Question </h1>
        <ol class="s-breadcrumbs mb-4">
            {{ now()->toDateTimeString() }}
        </ol>
        <!-- Serach bar and sorting-->
        <header class="s-topbar">
            <form id="search" class="s-topbar--searchbar" action="" method="GET" autocomplete="off">
                <div class="s-select">
                    <input type="hidden" id="orderby" name="sort" value="{{ $sort }}">
                    <select id="ordering" name="order">
                        <option value="" disabled >select sorting</option>
                        <option value="asc">A-Z</option>
                        <option value="desc">Z-A</option>
                    </select>
                </div>
                <div class="s-topbar--searchbar--input-group">
                    <input class="s-input s-input__search" type="text" name="search" placeholder="Search....."
                        value="{!! request('search') !!}" />
                </div>
            </form>
        </header>
        <script>
            $(document).ready(function() {
                $('#ordering').on("change", function() { // for id #
                    $('#orderby').val($(this).val());
                    $('#search').submit();
                });
            });
        </script>
        <!--create Question Start---->
        <ol class="s-breadcrumb mb-2 mt-2">
            <a href="{{ route('question.create') }}" class="btn btn-primary mt-2"> Ask Question</a>
        </ol>
    @foreach ($questions as $question)
        <div class="s-post-summary">
            <div class="s-post-summary--stats">
                <div class="s-post-summary--stats-item s-post-summary--stats-item__emphasized">
                    <span class="s-post-summary--stats-item-number">
                        {{-- {{ dd($question->count) }} --}}
                        {{ $question->count }}
                    </span>
                    <span class="s-post-summary--stats-item-unit">
                        votes
                    </span>
                </div>
                <div class="s-post-summary--stats-item has-answers has-accepted-answer">
                    <span class="s-post-summary--stats-item-number">
                        {{ (count($question->answer)) }}
                    </span>
                    <span class="s-post-summary--stats-item-unit">
                        answers
                    </span>
                </div>
                <div class="s-post-summary--stats-item is-supernova">
                    <span class="s-post-summary--stats-item-number">
                        {{ count($question->questionview) }}
                    </span>
                    <span class="s-post-summary--stats-item-unit">
                        views
                    </span>
                </div>
            </div>
            <div class="s-post-summary--content">
                <div class="s-post-summary--content-type">
                    <a href="…" class="s-link s-link__grayscale">
                    </a>
                </div>
                <h3 class="s-post-summary--content-title">
                    <a title="{{ $question->title }}" href="{{ route('question.show', $question->id) }}" class="s-link">
                        {{ $question->title }}
                    </a>
                </h3>
                <!-- <details> -->
                <!-- <summary>Click here</summary> -->
                <p class="s-post-summary--content-excerpt">
                    {!! Str::limit($question->body, 200) !!}
                </p>
                <!-- </details> -->
                <div class="s-post-summary--meta">
                    <div class="s-post-summary--meta-tags">
                        @php
                            $t=explode('"',$question->question_tag);
                            $res = str_replace( array( ',','"','[',']' ), '' , $t); // Returning the result return $res;
                            $tags=array_filter($res);
                            // dd($r);
                            // $tags=explode(',',$t);
                        @endphp
                        @foreach ($tags as $tag)
                        <a class="s-tag" href="#">
                            {{ $tag }}
                        </a>
                        @endforeach
                    </div>
                    <div class="s-post-summary--meta mt-4">
                        <div class="s-post-summary--meta-tags">
                            <strong> Created By:</strong>
                            <a href="#">
                                {{ $question->user->name }}
                            </a>
                            <time class="s-user-card--time">
                                {{ $question->created_at }}
                            </time>
                        </div>
                    </div>
                </div>
            </div>
            <span class="">
           @if ($question->user_id == auth()->id())
                <!-- <a href="https://demo.getcraftable.com/admin/tags/3/edit" title="Edit" role="button" class="btn btn-sm btn-spinner btn-info"><i class="fa fa-edit"></i></a> -->
                <a class="btn btn-primary" title="you can edit your question" href="{{ route('question.edit', $question->id) }}">
                    <i class="fas fa-edit" aria-hidden="true"></i></a>
                <form action="{{ route('question.destroy', $question->id) }}" method="POST">
                    <input name="_method" type="hidden" value="DELETE">
                    <button title="your question will be deleted permenantly" type="submit"
                        class="mt-2 mb-2 btn btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'>
                        <i class="far fa-trash-alt"></i>
                    </button>
                    @csrf
                    @method('DELETE')
                </form>
            @endif
            </span>
        </div>
    @endforeach
    {{-- {!! $questions->appends(Request::except('page'))->render() !!} --}}
    {{-- !! $questions->render() !! --}}
    {{ $questions->links() }}
    <p>
        Displaying
        {{ $questions->count() }}
        of
        {{ $questions->total() }}
        Questions(s).
    </p>
    </div>
@endsection
