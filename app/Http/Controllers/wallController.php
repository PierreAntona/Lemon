<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class wallController extends Controller
{
    public function index(){
        $posts = Post::all();
        return view('dashboard', ['posts' => $posts]);
    }

    public function postMessage(Request $resquest){
        if (empty($resquest->message)) {
            return redirect('dashboard')->with('error','message vide');
        }
        $post = new Post;


        $post->content = $resquest->message;
        $post-> owner = Auth::id();
        if ($resquest->media) {
            $file=Storage::put('public/media', $resquest->media);
            $file=str_replace('public/media', '', $file);
            $post->media= $file ;

        }
        $post->save();
        $resquest->session()->flash('success','posted on the wall !');
        return redirect()->route('dashboard');
    }

    public function postPage(Request $resquest){
        $post = Post::findOrFail($resquest->id);
        return view('posts', ['post' => $post]);
    }

    public function deletePost(Request $resquest){
        $post = Post::findOrFail($resquest->id);
        if(Auth::id() != $post->owner){
            abort(404);
        }
        $post->delete();


        return redirect()->route('dashboard');
    }

    public function updatePost(Request $resquest){
        $post = Post::findOrFail($resquest->id);
        if(Auth::id() != $post->owner){
            abort(404);
        }
        return view('updatePost', ['post' => $post]);
    }

    public function savePost(Request $resquest){
        $post = Post::find($resquest->id);
        if(Auth::id() != $post->owner){
            abort(404);
        }
        $post->content = $resquest->content;
        $post->save();
        return redirect()->route('dashboard');
    }
}
