<?php
namespace App\Http\Controllers;
use App\Models\Answer;
use Illuminate\Http\Request;
class AnswerController extends Controller
{
    public function storeAnswer(Request $request)
    {
        $request->validate([
            'answer' => 'required',
        ]);
        $input = $request->all(); //dd($input);
        $input['user_id'] = auth()->id();
        $answers = Answer::create($input); // dd($input);
        return redirect()->route('question.show', $input['question_id'])->with('success', 'Answer updated successfully.');
    }
    public function editAnswer($id)
    {
        $ans = Answer::where('id', $id)->firstOrFail();
        if ($ans->user_id !== auth()->id())  //this condition restrict user to maniplate URL
        {
            abort('403');
        }
        return response()->json('edit answer page.......!!!!!!!!');
        // return view('answer.edit', compact('ans'));
    }
    public function acceptAnswer(Request $request, $id)
    {
        //    dd($request);
        $input['answer_id'] = $request['answer_id'];
        // dd($input);
        $answer = Answer::find($input['answer_id']);
        $st = "Un-Accept";
        if ($answer['type'] === "Un-Accept") {
            $st = "Accept";
        }
        $answer->update(array(
            'type' => $st
        ));
        return redirect()->back()->with(['success' => 'Status change successfully.', 'type' => ucfirst($answer->type)]);
    }
    public function updateAnswer(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required',
        ]);
        $ans = Answer::where('id', $id)->firstOrFail();
        if ($ans->user_id !== auth()->id()) {     //this condition restrict user to maniplate URL
            abort('403');
        }
        $input = $request->all();
        $ans->update($input);
        return redirect()->route('question.index', $id)->with('success', 'Answer updated successfully.');
    }
    public function answerDelete($id)
    {
        $ans = Answer::where('id', $id)->firstOrFail();
        if ($ans->user_id !== auth()->id()) {     //this condition restrict user to maniplate URL
            abort('403');
        }
        $ans->delete();
        return redirect()->back()->with('success', 'Answer Deleted successfully.');
    }
}
