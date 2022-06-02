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

    public function postMessage(Request $resquest,$parentPost = 0){
        if (empty($resquest->message)) {
            return redirect('dashboard')->with('error','message vide');
        }
        $post = new Post;

        $post->parentPost=$parentPost;
        $post->content = $resquest->message;
        $post->owner = Auth::id();
        if ($resquest->media) {
            $file=Storage::put('public/media', $resquest->media);

            $file=str_replace('public/media', '', $file);
            $post->media= $file ;
            $post->mediaType= 'video' ;
            // storage/media/
            /*$mime = mime_content_type('storage/media/'.$file);
            if(strstr($mime, "video/")){
                $post->media= $file ;
            }else if(strstr($mime, "image/")){
            }else{
                Storage::delete('storage/media/'.$file);
                return redirect('dashboard')->with('error','erreur fichier');
            }*/

        }
        $post->save();
        $resquest->session()->flash('success','posted on the wall !');
        if ($parentPost!=0) {

            return redirect()->route('postPage',$parentPost);
        }
        return redirect()->route('dashboard');
    }

    public function postPage(Request $resquest){
        $post = Post::findOrFail($resquest->id);
        $comment = Post::all();
        return view('posts', ['post' => $post, 'comments' => $comment]);
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
