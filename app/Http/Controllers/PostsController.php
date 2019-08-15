<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Category;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;

class PostsController extends Controller
{

    public function __construct(){
       $this->middleware('VerfifyCategoriesCount')->only(['create', 'store']);     
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {

       

       
        //upload the image
         $image=$request->image->store('posts');


        // create the post
        $post=Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' =>$request->content,
            'image' => $image,
            'published_at'=>$request->published_at,
            'category_id' =>$request->category
        ]);

        if($request->tags){
            $post->tags()->attach($request->tags);
        }

    

        //flash the message
        session()->flash('success', 'Post Created Successfully');
        
        //redirect
        return redirect(route('posts.index'));

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
    public function edit(Post $post)
    {
        //
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request,Post $post)
    {
        
        $data=$request->only(['title', 'description', 'published_at', 'content']);
        //Check if new Image
        if($request->hasFile('image')){
         //Upload it
        $image= $request->image->store('posts');
        //Delete the old one
        
        
        $data['image']= $image;
            
        }

        if($request->tags){
            $post->tags()->sync($request->tags);
        }

        //Update attributes
        $post->update($data);

        //flash the message
        session()->flash('success', 'Post updated Successfully');
        
        //redirect
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
       
        $post=Post::withTrashed()->where('id', $id)->firstOrFail();
        if($post->trashed())
        {
            $post->deleteImage();
            $post->forceDelete();
        }else{
            $post->delete();
        }

        //flash the message
        session()->flash('success', 'Post Deleted Successfully');
        
        //redirect
        return redirect(route('posts.index'));
  
    }

    // Display the list of all thrashed post
    public function thrashed(){
       
        
        // $thrashed = Post::withTrashed()->get();
        $thrashed = Post::onlyTrashed()->get();
       

           //redirect
         return view('posts.index')->withPosts($thrashed);
        
    }


    public function restore($id)
    {
        $post=Post::withTrashed()->where('id', $id)->firstOrFail();
        //Restore trash post
        $post->restore();


         //flash the message
         session()->flash('success', 'Post Restored Successfully');

           //redirect
        return redirect()->back();
  
        
    }
}
