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

        $file=Storage::put('public/media', $resquest->media);
        $file=str_replace('public/media', '', $file);
        $post->content = $resquest->message;
        $post-> owner = Auth::id();
        if ($resquest->media) {
            $post->media= $file ;
        }
        $post->save();
        $resquest->session()->flash('success','posted on the wall !');
        return redirect()->route('dashboard');
    }


}
