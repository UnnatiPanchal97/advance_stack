<?php
namespace App\Http\Controllers;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        // $perPage = $request->input('limit');  
        $sort = $request->input('sort');
        if ($sort == null) {
            $sort = "asc";
        }
        // dd($sort);
        $questions = Question::with('questionvotes', 'answer', 'questionview',  'user')->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
            })->orwhere('title', 'LIKE', "%{$search}%")->orWhere('body', 'LIKE', "%{$search}%")->orderBy('title', $sort)->orderBy('body', $sort)->latest()->paginate(5);
            // dd($questions);
            $date = Carbon::now();
        return view('questions', compact('questions', 'sort','date'));
        // return view('questions');
    }
}
