<x-app-layout>
    <div class="flex border-x justify-between">

        @include('components.sidebar')

        <div class=" w-full flex flex-col justify-center items-center">
            <div class="px-8 py-4 w-full flex justify-between items-center">
                <h1 class="px-4 text-2xl font-bold text-emerald-500">Accueil</h1>
                <form class="flex items-center" method="POST" action="{{route('search')}}">
                    <input type="text" name="search" class="rounded-full mr-3" placeholder="Recherche Lemon" />
                    @csrf
                    <x-heroicon-o-search class="w-8 h-8 text-emerald-500 cursor-pointer">
                        <input type="submit">
                    </x-heroicon-o-search>
                </form>
            </div>
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    @include('components.post-box')
                    @foreach($posts as $post)
                    <div class="flex flex-col space-x-3 border-y p-5 border-gray-100 ">
                        @if($post->parentPost==0)
                        <div class="flex space-x-3 ">
                        <a href="{{ route('profil', $post->owner) }}"><img class="h-10 w-10 rounded-full object-cover" src='https://links.papareact.com/gll' alt="" /></a>
                            <div class="w-full">
                                <div class="flex w-full justify-between items-center space-x-1">
                                    <p class="mr-1 font-bold">{{$post->owner}}</p>
                                    @if($post->owner== Auth::user()->name )
                                    <a href="{{route('postPage', $post->id)}}">
                                        <x-heroicon-o-pencil-alt class="w-5 h-5 hover:text-emerald-500" />
                                    </a>
                                    @endif
                                </div>
                                <p class="pt-1">{{$post->content}}</p>
                                @if($post->media)
                                @if($post->mediaType=='image')
                                <img class="m-5 ml-0 mb-1 max-h-60 rounded-lg object-cover shadow-sm" src="{{url('storage/media/'.$post->media)}}" alt="Image" />
                                @elseif($post->mediaType=='video')
                                <video class="m-5 ml-0 mb-1 max-h-60 rounded-lg object-cover shadow-sm" width="320" height="240" controls>
                                    <source src="{{url('storage/media/'.$post->media)}}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="mt-5 flex justify-between">
                            <div class="flex cursor-pointer items-center space-x-3 text-gray-400">
                                <x-heroicon-o-chat-alt-2 class="h-5 w-5" />
                                <p>0</p>
                            </div>
                            <div class="flex cursor-pointer items-center space-x-3 text-gray-400">
                                <x-heroicon-o-switch-horizontal class="h-5 w-5" />
                            </div>

                            <div class="flex cursor-pointer items-center space-x-3 text-gray-400">
                                <x-heroicon-o-heart class="h-5 w-5" />
                            </div>

                            <div class="flex cursor-pointer items-center space-x-3 text-gray-400">
                                <x-heroicon-o-share class="h-5 w-5" />
                            </div>
                        </div>
                        <form method="POST" enctype="multipart/form-data" action="{{route('postMessage',$post->id)}}" class="mt-5 flex items-center">
                            @csrf
                            <input type="text" name="message" placeholder="Votre réponse" class="flex-1   p-2 outline-none mr-2" />
                            <label for="media">
                                <x-heroicon-o-photograph class="w-6 h-6 text-gray-500 cursor-pointer mr-4" />
                                <input type="file" name="media" id="media" style="display: none;" />
                            </label>
                            <input type="submit" value="Poster" class="text-emerald-500 cursor-pointer ml-2" />
                        </form>
                        @foreach($comments as $comment)
                        @if($comment->parentPost == $post->id)
                        <div class='my-2 mt-5 max-h-44 space-y-5 border-t border-gray-100 p-5'>
                            <div class='relative flex space-x-2'>
                                <hr class='absolute left-5 top-10 h-8 border-x border-emerald-500/30' />
                                <img src='https://links.papareact.com/gll' class="mt-2 h-7 w-7 object-cover rounded-full" alt="" />
                                <div class=''>
                                    <div class="flex items-center space-x-1">
                                        <p class='mr-1 font-bold'>{{$comment->owner}}</p>
                                        <p class="text-sm text-gray-500">{{$comment->created_at}}</p>
                                    </div>
                                        <!-- @if($comment->media)
                                        <img class="m-5 ml-0 mb-1 max-h-60 rounded-lg object-cover shadow-sm" src="{{url('storage/media/'.$post->media)}}" alt="Image" />
                                        @endif -->
                                    <p>{{$comment->content}}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

</x-app-layout>