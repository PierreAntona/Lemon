<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accueil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Fil d'actualité
                    <form method="POST"  enctype="multipart/form-data" action="{{route('postMessage')}}">
@csrf
                        <input type="text" name="message"/>
                        <input type="file" name="media"/>
                        <input type="submit"/><br>
                    <b>Posts</b> : <br>
                    @foreach($posts as $post)
                        <a href="{{route('postPage', $post->id)}}"><ul>
                            <li>{{$post->owner}} _ {{$post->content}}</li>
                            @if($post->media)
                            <img src="{{url('storage/media/'.$post->media)}}" alt="Image"/>
                            @endif

                        </ul></a>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
