<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class wallController extends Controller
{
    public function index(){
        // $post = [];
        // $mesAbonnementsId = Subscriber::where('follower', Auth::user()->id)->get();
        // foreach ($mesAbonnementsId as $element) {
        //     $profil = User::where('id', $element->user)->get()->firstOrFail();
        //     array_push($post, Post::where('owner', $profil->name)->get());
        // }

        $subscribers = Subscriber::all();
        $posts = Post::where('parentPost',0)->get();
        $comments = Post::where('parentPost','>',0)->get();
        return view('dashboard', ['posts' => $posts, 'comments' => $comments, 'subscribers' => $subscribers]);
    }

    public function profil(Request $request){
        $profil = User::where('name',$request->name)->get();
        $posts = Post::where('owner', $request->name)->get();
        $comments = Post::where('parentPost','>',0)->get();
        $subscriber = Subscriber::where('user',  $profil[0]->name)->get()->count();
        $subscription = Subscriber::where('follower', $profil[0]->name)->get()->count();
        $estAbonne = Subscriber::where([['user',  $profil[0]->name],['follower',  Auth::user()->name]])->get()->count();
        // $estAbonne = Subscriber::findOrFail('follower', )
        return view('profil', ['profil' => $profil, 'posts' => $posts, 'comments' => $comments, 'subscriber' => $subscriber, 'subscription' => $subscription,'estAbonne' => $estAbonne]);
    }

    public function follow(Request $request){
        $subscriber = new Subscriber;
        $subscriber->user = $request->user;
        $subscriber->follower = Auth::user()->name;
        $subscriber->save();
        $profil = User::where('name',$request->user)->get()->firstOrFail();
        return redirect()->route('profil',$profil->name);
    }

    public function unfollow(Request $request){
        // $subscriber = Subscriber::findOrFail($request->user);
        $subscribers = Subscriber::where([['user',  $request->user],['follower',  Auth::user()->name]])->get();
        foreach ($subscribers as $item){
                $subscriber = Subscriber::findOrFail($item->id);
                $subscriber->delete();

        }
        $profil = User::where('name',$request->user)->get();

         return redirect()->route('profil',$profil[0]->name);
    }

    public function postMessage(Request $resquest,$parentPost = 0){
        if (empty($resquest->message)) {
            return redirect('dashboard')->with('error','message vide');
        }
        $post = new Post;
        $post->parentPost=$parentPost;
        $post->content = $resquest->message;
        $post->owner = Auth::user()->name;
        if ($resquest->media) {
           /* $file=Storage::put('public/media', $resquest->media);

            $file=str_replace('public/media', '', $file);
            $post->media= $file ;
            $post->mediaType= 'video' ;*/
            $uploadType = $resquest->media->getMimeType();
            if(in_array($uploadType, array("image/jpeg", "video/webm", "video/mp4", "image/jpg", "image/gif", "image/png"))) {
                $file=Storage::put('public/media', $resquest->media);
                $file=str_replace('public/media', '', $file);
                $post->media= $file ;
                // dd("ici");
                $type = str_contains($uploadType , 'image') ? 'image' : 'video';
                $post->mediaType= $type;
            } else {
                abort(422, "pas le bon format");
            }
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
        $comment = Post::where('parentPost',$resquest->id)->get();
        return view('posts', ['post' => $post, 'comments' => $comment]);
    }

    public function deletePost(Request $resquest){
        $post = Post::findOrFail($resquest->id);
        if(Auth::user()->name != $post->owner){
            abort(404);
        }
        $post->delete();


        return redirect()->route('dashboard');
    }

    public function updatePost(Request $resquest){
        $post = Post::findOrFail($resquest->id);
        if(Auth::user()->name != $post->owner){
            abort(404);
        }
        return view('updatePost', ['post' => $post]);
    }

    public function savePost(Request $resquest){
        $post = Post::find($resquest->id);
        if(Auth::user()->name != $post->owner){
            abort(404);
        }
        $post->content = $resquest->content;
        $post->save();
        return redirect()->route('dashboard');
    }
}
