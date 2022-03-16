<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PostController extends Controller
{
    public function index()
    {
        $post = Post::latest()->get();
        
        return view('posts.index',['posts'=>$post]);
    }

    //step 5
    public function create()
    {
        return view('posts.create');
    }

    //
    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'author' => 'required',
            'sinopsis' => 'required',
            'penerbit' => 'required'
        ]);

        $post = Post::create([
            'judul' => $request->judul,
            'author' => $request->author,
            'sinopsis' => $request->sinopsis,
            'penerbit' => $request->penerbit,
            'slug' => Str::slug($request->title)
        ]);

        if ($post) {
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'Buku berhasil ditambahkan'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Eror, silahkan coba lagi'
                ]);
        }
    }


    //
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    //
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required|string|max:155',
            'author' => 'required',
            'sinopsis' => 'required',
            'penerbit' => 'required'
        ]);

        $post = Post::findOrFail($id);

        $post->update([
            'judul' => $request->judul,
            'author' => $request->author,
            'sinopsis' => $request->sinopsis,
            'penerbit' => $request->penerbit,
            'slug' => Str::slug($request->judul)
        ]);

        if ($post) {
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'Post berhasil di update'
                ]);
        }  else {
            return redirect()
                ->back()
                 ->withInput()
                ->with([
                    'error' => 'Eror, silahkan coba lagi'
                ]);
        }
    }
    
    //
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        if ($post) {
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'Post berhasil dihapus'
                ]);
        } else {
            return redirect()
                ->route('post.index')
                ->with([
                    'error' => 'Eror, silahkan coba lagi'
                ]);
        }
    }
}

