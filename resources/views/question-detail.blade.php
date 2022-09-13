@extends('layouts.admin.app')
@section('content')
    @if ($message = Session::get('success'))
        <div>
            <div class="alert alert-success mt-3">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif
    <style>
    </style>
    <div class="container pt-4">
        <h1>Review Question</h1>
        <ol class="breadcrumb mb-4">
            <a class="btn btn-primary mr-2" href="{{ route('home') }}"> Back</a>
        </ol>
        <!-- <div class="container-fluid px-4"> -->
        <div class="s-page-title">
            <h1 class="s-page-title--header">{{ $question->title }}</h1>
        </div>
        {{-- questionvotes --}}
        <div class="d-flex ">
            {{-- my48 --}}
            <div class="row my48">
                <div class="span text-center">
                    <div id="templates" class="mb-2">
                        <button id="upvote" class="btn btn-xs btn-outline-success upvote-btn" value="upvote">Upvote</button>
                    </div>
                    {{ dd(($qv[0]->question_id)) }}
                    <span class="count" title="Total number of votes">
                        @if ($questionvotes)
                            {{ count($questionvotes) }}
                        @else
                            0
                        @endif
                    </span>
                    <div class="mt-2">
                        <button id="downvote" class="btn btn-xs btn-outline-danger downvote-btn" value="downvote">Downvote</button>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#upvote').on('click', function(e) {
                                // $(this).toggleClass('b');
                                $(this).addClass('upvote-btn on');
                                $(this).toggleClass('upvote');
                                // alert('upvote');
                                var params = [];
                                params['vote_for'] = 'question';
                                params['url'] =
                                    @if (count($questionvotes))
                                        '{{ route('question.votes', $questionvotes[0]->id) }}'
                                    @else
                                        '{{ route('question.votes') }}'
                                    @endif ;
                                params['headers'] = {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                };
                                params['type'] = 'GET';
                                params['count'] = {{ $question->count }};
                                params['values'] = {
                                    'question_id': '{{ $question->id }}',
                                    'user_id': '{{ auth()->user()->id }}'
                                };
                                console.log(params);
                                    $.ajax({
                                        url: params.url,
                                        headers: params.headers,
                                        type: params.type,
                                        data: {
                                            'question_id' : params.values.question_id,
                                            'user_id' :params.values.user_id,
                                            'count' : params.count,
                                        },
                                        success: function(data, status, xhr) {
                                            //$("#examples").load(location.href + " #examples > *");
                                            //$("#templates").load(location.href + " #templates > *");
                                            // location.reload();
                                            // console.log(data);
                                        },
                                    });
                                // params['callback'] = callback;
                                // console.log(params['callback']);
                            // };
                            // });
                            $('#downvote').on('click', function() {
                                alert('downvote');
                            });
                        });
                    });
                    </script>
                    {{-- <div class="examples" id="questionvotes"></div> --}}
                    {{-- <div class="content-center">
                    <div id="questionvotes" class="upvote">
                        <a class="upvote" title="This is good stuff. Vote it up! (Click again to undo)">
                        </a>
                        <span class="count" title="Total number of votes">@if (isset($question->questionvotes)){{
                            count($question->questionvotes) }}@else 0 @endif</span>
                        <a id="downvote" class="downvote"
                            title="This is not useful. Vote it down. (Click again to undo)">
                        </a>
                    </div>
                </div> --}}
                    {{-- <script type="text/javascript">
                    $(document).ready(function(){
                    $('#questionvotes').upvote({
                        count: @if (isset($question->questionvotes)){{ count($question->questionvotes) }}@else 1 @endif ,
                        upvoted: true,
                        downvoted: false
                    });
                    $('#questionvotes').upvote('downvote');
                    $('#questionvotes').upvote('upvote');
                    $('#questionvotes').upvote('count');
                    $('#questionvotes').upvote('upvoted');
                    $('#questionvotes').upvote('downvoted');
                });
                </script> --}}
                </div>
            </div>
            <div class="s-post-summary">
                <div class="s-post-summary--content">
                    <div class="s-post-summary--content-type">
                    </div>
                    <p class="s-post-summary--content-excerpt">{!! $question->body !!}</p>
                    <div class="s-post-summary--meta">
                        <div class="s-post-summary--meta-tags">
                            @php
                                $t = explode('"', $question->question_tag);
                                $res = str_replace([',', '"', '[', ']'], '', $t); // Returning the result return $res;
                                $tags = array_filter($res);
                                // dd($r);
                                // $tags=explode(',',$t);
                            @endphp
                            @foreach ($tags as $tag)
                                <a class="s-tag" href="#">
                                    {{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <ol class="breadcrumb mt-2">
                        <strong class="mr-2 "> Created By:</strong>
                        <a href="" class="s-user--link"> {{ $question->user->name }}</a>
                    </ol>
                    @if ($question->user_id == auth()->id())
                        <form action="{{ route('question.destroy', $question->id) }}" method="POST">
                            <a class="btn btn-link" title="you can edit your question"
                                href="{{ route('question.edit', $question->id) }}">Edit</a>
                            <input name="_method" type="hidden" value="DELETE">
                            <button title="your question will be deleted permenantly " type="submit"
                                class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip"
                                title='Delete'>Delete</button>
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                    </span>
                </div>
            </div>
        </div>
        <!---end of question part----->
        <!--Answer Part-->
        {{-- dd($question->createdby) --}}
        {{-- {{ dd($question->answer) }} --}}
        <div class="s-page-title">
            <h1 class="s-page-title--header">Answer</h1>
        </div>
        @foreach ($question->answer as $ans)
            <div class="d-flex ">
                <div class="s-post-summary">
                    {{-- dump($ans->id) --}}
                    <div class="s-post-summary--answer">
                        <div class="s-post-summary--stats">
                            <div class="s-post-summary--stats-item s-post-summary--stats-item__emphasized">
                                <div class="s-post-summary--stats-item">
                                    @if ($question->user_id == auth()->id())
                                        <form action="{{ route('accept-answer', ['type' => 'Accept', 'id' => $ans->id]) }}"
                                            method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="question_id" value="{{ $question->id }}" />
                                            <input type="hidden" name="answer_id" value="{{ $ans->id }}" />
                                            @if ($ans->type == 'Pending')
                                                <input class="s-btn s-btn__outlined " type="submit" name="type"
                                                    value="Accept" />
                                            @elseif ($ans->type == 'Accept')
                                                <input class="s-btn s-btn__outlined" type="submit" name="type"
                                                    value="Un-Accept" />
                                            @else
                                                <input class="s-btn s-btn__outlined" type="submit" name="type"
                                                    value="Accept" />
                                            @endif
                                            @csrf
                                            @method('POST')
                                        </form>
                                        <div class="toggle-btn">
                                            <button data-answer="{{ $ans->id }}" data-question="{{ $question->id }}"
                                                class="toggle-class-data btn btn-primary">
                                                {{ $ans->type }}
                                            </button>
                                        </div>
                                    @endif
                                    @if ($ans->type == 'Accept')
                                        <div class="s-post-summary--stats-item has-answers has-accepted-answer">
                                            Accepted
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <p class="s-post-summary--answer-excerpt">{!! $ans->answer !!}</p>
                        <div class="s-post-summary--answer-type">
                            <div class="s-user-card s-user-card__minimal">
                                <a href="#" class="s-avatar s-user-card--avatar">
                                    <img class="s-avatar--image" src="#" />
                                </a>
                            </div>
                            <div class="s-user-card--info">
                                <span>Created By:</span> <a href="#"
                                    class="s-user-card--link">{{ $ans->user['name'] }}</a>
                                <ul class="s-user-card--awards">
                                    <li class="s-user-card--rep"></li>
                                </ul>
                            </div>
                            <time class="s-user-card--time">{{ $ans->created_at }}</time>
                        </div>
                        <span>
                            @if ($ans->user_id == auth()->id())
                                <form action="{{ url('deleteanswer/' . $ans->id) }}" method="POST">
                                    <a class="s-anchors s-anchors__default"
                                        href="{{ url('answers/' . $ans->id . '/edit') }}">Edit</a>
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button title="your question will be deleted permenantly" type="submit"
                                        class="s-btn s-btn__danger btn-flat show_confirm" data-toggle="tooltip"
                                        title='Delete'>Delete</button>
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
        <!--Answer Part end--->
        <!---text editor part---->
        <!-- <div class="container-fluid px-4"> -->
        <form action=" {{ route('submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="answer"><strong> Your Answer <span class="text-danger">*</span></strong></label>
                    <textarea class="ckeditor form-control" name="answer"></textarea>
                    @if ($errors->has('answer'))
                        <span class="text-danger">{{ $errors->first('answer') }}</span>
                    @endif
                </div>
            </div>
            <input type="hidden" name="question_id" value="{{ $question->id }}" />
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Post Your Answer</button>
            </div>
        </form>
        {{-- dd($ans) --}}
        {{-- <script>
        $(document).on('click','.toggle-class-data', function(){
                var $this = $(this),
                answerId = $this.attr('data-answer'),
                questionId =  $this.attr('data-question'),
                urlMain = "{{ route('accept-answer',':id') }}",
                url = urlMain.replace(':id', answerId);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({ 
                        type: "POST", 
                        dataType: "json", 
                        url:url,
                        data: {'question_id' : questionId, 'answer_id': answerId}, 
                        success: function(data){ 
                            // console.log(data.success);
                            $this.html(data.type);
                        } 
                }); 
        });
    </script> --}}
        {{-- <script type="text/javascript">
        $(document).ready(function(){
                    var params = [];
                    params['vote_for'] = 'question';
                    params['url'] = @if (count($questionvotes))'{{ route("question.votes", $questionvotes[0]->id) }}'@else'{{ route("questions.votes") }}'@endif;
                    params['headers'] = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};        
                    params['type'] = 'GET';
                    params['count'] = {{ $question->count }};
                    params['data'] = {'question_id' : '{{ $question->id }}', 'user_id' : '{{ auth()->user()->id }}'};
                    // console.log(params);
                });
    </script> --}}
        <style>
            .hidden {
                display: none;
            }
            .questionvotes {
                overflow: auto;
            }
            .questionvotes div.upvotejs {
                float: left;
            }
            #footer {
                height: 60px;
                background-color: #f5f5f5;
            }
        </style>
    @endsection
