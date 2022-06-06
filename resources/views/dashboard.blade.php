<x-app-layout>
    <div class="flex border-x justify-between">

        @include('components.sidebar')

        <div class="py-12 w-full flex justify-center items-center">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    @include('components.post-box')
                    @foreach($posts as $post)
                    <div class="flex flex-col space-x-3 border-y p-5 border-gray-100 ">
                        @if($post->parentPost==0)
                        <div class="flex space-x-3">
                            <img class="h-10 w-10 rounded-full object-cover" src='https://links.papareact.com/gll' alt="" />
                            <div>
                                <div class="flex items-center space-x-1">
                                    <p class="mr-1 font-bold">{{$post->owner}}</p>
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

                                <a href="{{route('postPage', $post->id)}}">OPEN</a>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

</x-app-layout>