<?php
namespace App\Http\Controllers;
use App\Http\Requests\TagStore;
use App\Models\Tag;
use Illuminate\Http\Request;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags=Tag::paginate(5);
        return view('tags.index',compact('tags'))->with('i', (request()->input('page', 1) - 1) * 5); 
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagStore $request)
    {
        Tag::create($request->all());
        return redirect()->route('tag.index')->with('success','Tag added successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        // dd($id);
        // $tag=Tag::find($id);
        // dd($tag);
        return view('tags.edit',compact('tag'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagStore $request, Tag $tag)
    {
        $data=$request->all(); 
        $tag->update($data);
        return redirect()->route('tag.index')->with('success','Tag updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tag.index')->with('success','Tags deleted successfully');
    }
}