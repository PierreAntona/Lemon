<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Message #{{ $post->id }}<br>
                    <text>{{ $post->content }}</text><br>
                    <!-- Media if exists -->
                    <a href="{{route('updatePost', $post->id)}}"><b>#Modifier#</b></a>
                    <a href="{{route('deletePost', $post->id)}}"><b>#Supprimer#</b></a>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Commentaires #{{ $post->id }}<br>
                    <form method="POST"  enctype="multipart/form-data" action="{{route('postMessage',$post->id)}}">
@csrf
                        <input type="text" name="message"/>
                        <input type="file" name="media"/>
                        <input type="submit"/><br>
                        @foreach($comments as $comment)
                                <a href="{{route('postPage', $comment->id)}}"><ul>
                                    <li>{{$comment->owner}} _ {{$comment->content}}</li>
                                    @if($post->media)
                                    <img src="{{url('storage/media/'.$comment->media)}}" alt="Image"/>
                                    @endif

                                </ul></a>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
