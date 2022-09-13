<?php
namespace App\Http\Controllers;
use App\Http\Requests\QuestionRequest;
use App\Models\Answer;
use App\Models\AnswerVote;
use App\Models\Question;
use App\Models\QuestionView;
use App\Models\QuestionVote;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Support\Facades\Auth;
class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return view('ask-questions');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::get(); /// we created object of tags to get data of tag table using relations         
        // dd($tags);
        return view('ask-questions', compact('tags'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $request['user_id'] = Auth::user()->id;
        $request['question_tag'] = json_encode($request['question_tag']);
        // dd($request);
        Question::create($request->all());
        // $question->tag()->attach($request->data('tag_id'));
        // dd($request->data('tag'));
        return redirect()->route('home')->with('success', 'Questions Added successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question, Answer $ans)
    {
         $mvArr = array(
            'user_id' => auth()->id(),
            'question_id' => $question['id'],
        );//dd($mvArr);
        $mv = QuestionView::where($mvArr)->exists(); //exist mean true false
        // dd($mv);
        if ($mv !== true)    {
            QuestionView::create(array(
                'user_id' => auth()->id(),
                'question_id' => $question['id'],
            ));
        }
        // $ans = Answer::find($id);
        // $ans=Answer::get()->pluck('id');
        // dd($ans);
        $ans = null;
        $questionvotes = QuestionVote::where("question_id", "=", $question['id'])->where("user_id", "=", auth()->user()->id)->get();
        $qv=QuestionVote::with('questions')->get();
        $answervotes = new AnswerVote();
        // dd($answervotes->replyvotes);
        return view('question-detail', compact('question','qv', 'ans', 'questionvotes', 'answervotes'));
        //return view('question-detail');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
         if ($question->user_id !== auth()->id()) {     //this condition restrict user to maniplate URL
            abort('403');
        }
        $tags = Tag::get();
        return view('question-edit', compact('question', 'tags'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $input = $request->all();
        // dd($input);
        if ($question->user_id !== auth()->id()) {     //this condition restrict user to maniplate URL
            abort('403');
        }
        $question->question_tag=implode('"',$input['question_tag']);
        // dd($question);   
        $question->update($input);
        // dd($question);
        // $question->sync($request->input('question_tag'));
        return redirect()->route('home')->with('success', 'Questions updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
         if ($question->user_id == auth()->id()) //this condition restrict user to maniplate URL
        {
            $question->delete();
            return redirect()->route('home')->with('success', 'questions deleted successfully');
        }
    }
    public function answerCastVote(Request $request, $voteid = null)
    {
        $request->validate([
            'question_id' => 'required',
            'answer_id' => 'required',
            'user_id' => 'required',
            'action' => 'required',
            'count' => 'required',
        ]);
        $input['answer_id'] = $request['answer_id'];
        $input['user_id'] = $request['user_id'];
        $input['vote_type'] = $request['action'];
        $input['count'] = $request['count'];
        //dd($input);
        $answervotedetails = AnswerVote::updateOrCreate(['id' => $voteid], $input);
        $answerdetails = Answer::find($input['answer_id']);
        $answerdetails['count'] = $input['count'];
        $answerdetails->save();
        return redirect()->route('question.show', $request['question_id']);
    }
    public function questionCastVote(Request $request, $voteid = null)
    {
        $request->validate([
            'question_id' => 'required',
            'user_id' => 'required',
            // 'action' => 'required',
            'count' => 'required',
        ]);
        $input['question_id'] = $request['question_id'];
        $input['user_id'] = $request['user_id'];
        $input['vote_type'] = $request['action'];
        $input['count'] = $request['count'];
        //dd($input);
        $questionvotedetails = QuestionVote::updateOrCreate(['id' => $voteid], $input);
        $questiondetails = Question::find($input['question_id']);
        $questiondetails['count'] = $input['count'];
        $questiondetails->save();
        return redirect()->route('question.show', $request['question_id']);
    }
}