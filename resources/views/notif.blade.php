<x-app-layout>
    <div class="flex border-x justify-between">
        @include('components.sidebar')

        <div class=" w-full flex flex-col py-2">
            <div class="px-8 py-4 w-full flex justify-between items-center">
                <h1 class="px-4 text-2xl font-bold text-emerald-500">Notifications</h1>
                <form class="flex items-center" method="POST" action="{{route('search')}}">
                    <input type="text" name="search" class="rounded-full mr-3" placeholder="Recherche Lemon" />
                    @csrf
                    <x-heroicon-o-search class="w-8 h-8 text-emerald-500 cursor-pointer">
                        <input type="submit">
                    </x-heroicon-o-search>
                </form>
            </div>

            @foreach($notif as $info)
            <div class="mx-4 p-3 border-b">
                @if($info->seen)
                <p class="">{{$info->content}}</p>
                @elseif(!$info->seen)
                <p class="text-red-500 font-bold">{{$info->content}}</p>
                @endif
            </div>
            @endforeach
</x-app-layout>