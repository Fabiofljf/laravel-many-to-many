<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request; // 👈 Import the Request class
use Illuminate\Support\Facades\Auth; // 👈 Import the Validation Rule class
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendFirstEmail;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderByDesc('id')->get();
        //dd($posts);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        //dd($categories);
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //ddd($request->all());

        /* TODO
        Validate all tags */

        // Validate data
        $val_data = $request->validated();

        // se l'id esiste tra gli id della tabelal categories

        // Gererate the slug
        $slug = Post::generateSlug($request->title);
        $val_data['slug'] = $slug;

        //dd($val_data);
        // assign the post to the authenticated user
        $val_data['user_id'] = Auth::id();

        // Verifico se la richiesta contiene un file (1°metodo)
        if(array_key_exists('cover_image', $request->all())){
            // Valido il file
            $request->validated([
                "cover_image" => "nullable|image|max:5"
            ]);
            // Salvo nel filesystem
            $path = Storage::put('post_images', $request->cover_image);
            // passo il percorso all'array di dati validati per salvare la risorsa
            $val_data['cover_image'] = $path;
        }
        // create the resource
        $new_post = Post::create($val_data);
        $new_post->tags()->attach($request->tags);

        // redirect to a get route
        return redirect()->route('admin.posts.index')->with('message', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        /* Use the standard Request ☝ */
        //dd($request->all());

        // validate data
        //$val_data = $request->validated();

        /* ⚡ Validation unique ⚡*/
        $val_data = $request->validate([
            'title' => ['required', Rule::unique('posts')->ignore($post)],
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'exists:tags,id',
            'cover_image' => 'nullable',
            'content' => 'nullable',
        ]);

        // verificare se la richiesta contiene un file (2°metodo)
        if ($request->hasFile('cover_image')) {
            // validare il file
            $request->validate([
                'cover_image' => 'nullable|image|max:300'
            ]);
            // salvo il file nel filesystem
            // recupero il percorso
            //ddd($request->all());
            $path = Storage::put('post_images', $request->cover_image);
            // passo il percorso all'array di dati validati per salvare la risorsa
            $val_data['cover_image'] = $path;
        }

        //dd($val_data);
        // Gererate the slug
        $slug = Post::generateSlug($request->title);
        //dd($slug);
        $val_data['slug'] = $slug;
        // update the resource
        $post->update($val_data);

        //Sync tags
        $post->tags()->sync($request->tags);

        //return (new SendFirstEmail($post))->render();
        Mail::to('fabio@fabio.it')->send(new SendFirstEmail($post));

        // redirect to get route
        return redirect()->route('admin.posts.index')->with('message', "$post->title updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // elimino l'immagine vecchia
        Storage::delete($post->cover_image);
        //elimino la risorsa

        $post->delete();

        return redirect()->route('admin.posts.index')->with('message', "$post->title deleted successfully");
    }
}
