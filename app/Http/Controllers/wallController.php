<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class wallController extends Controller
{
    public function index(){
        $subscribers = Subscriber::all();
        $profil = User::all();
        $posts = Post::where('parentPost',0)->get();
        $comments = Post::where('parentPost','>',0)->get();
        return view('dashboard', ['profil' => $profil, 'posts' => $posts, 'comments' => $comments, 'subscribers' => $subscribers]);
    }

    public function profil(Request $request){
        $profil = User::where('name',$request->name)->get();
        $posts = Post::where('owner', $request->name)->get();
        $comments = Post::where('parentPost','>',0)->get();
        $subscriber = Subscriber::where('user',  $profil[0]->name)->get()->count();
        $subscription = Subscriber::where('follower', $profil[0]->name)->get()->count();
        $estAbonne = Subscriber::where([['user',  $profil[0]->name],['follower',  Auth::user()->name]])->get()->count();
        return view('profil', ['profil' => $profil, 'posts' => $posts, 'comments' => $comments, 'subscriber' => $subscriber-1, 'subscription' => $subscription - 1,'estAbonne' => $estAbonne]);
    }

    public function follow(Request $request){
        $subscriber = new Subscriber;
        $subscriber->user = $request->user;
        $subscriber->follower = Auth::user()->name;
        $subscriber->save();
        $profil = User::where('name',$request->user)->get()->firstOrFail();
        $notif = new Notification;
        $notif->owner = $request->user;
        $notif->provider = Auth::user()->name;
        $notif->content = Auth::user()->name." s'est abonné à votre profil.";
        $notif->save();
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

    public function editProfil(Request $request){
        $profil = User::where('name',$request->name)->get();
        return view('editProfil', ['profil' => $profil]);
    }

    public function updateProfil(Request $request){
        $profil = User::where('name', Auth::user()->name)->first();
        $uploadType = $request->media->getMimeType();
        if(in_array($uploadType, array("image/jpeg", "video/webm", "video/mp4", "image/jpg", "image/gif", "image/png"))) {
            $file=Storage::put('public/profil', $request->media);
            $file=str_replace('public/profil', '', $file);
            $profil->photo= $file;
        } else {
            abort(422, "pas le bon format");
        }
        $profil->save();
        return redirect()->route('dashboard');
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
            $notif = new Notification;
            $UserParentPost = Post::where('id',$parentPost)->get()->firstOrFail();
            $notifOwner = $UserParentPost->owner;
            $notif->owner = $notifOwner;
            $notif->provider = Auth::user()->name;
            $notif->content = Auth::user()->name." a commenté votre post.";
            $notif->save();
            return redirect()->route('postPage',$parentPost);
        }
        return redirect()->route('dashboard');
    }

    public function postPage(Request $resquest){
        $profil = User::where('name',Auth::user()->name)->get();
        $post = Post::findOrFail($resquest->id);
        $comment = Post::where('parentPost',$resquest->id)->get();
        return view('posts', ['post' => $post, 'comments' => $comment, 'profil' => $profil]);
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

    public function notif(Request $request){
        $notif = Notification::where('owner',Auth::user()->name)->get();
        return view('notif', ['notif' => $notif]);
    }

}
