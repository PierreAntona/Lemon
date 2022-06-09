<x-app-layout>
<div class="flex border-x justify-between">
        @include('components.sidebar')

        <div class=" w-full flex flex-col py-2">

            <div class="px-8 py-4 w-full flex justify-between items-center">
                <h1 class="px-4 text-2xl font-bold text-emerald-500">Modification</h1>
                <form class="flex items-center" method="POST" action="{{route('search')}}">
                    <input type="text" name="search" class="rounded-full mr-3" placeholder="Recherche Lemon" />
                    @csrf
                    <x-heroicon-o-search class="w-8 h-8 text-emerald-500 cursor-pointer">
                        <input type="submit">
                    </x-heroicon-o-search>
                </form>
            </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{route('savePost',$post->id)}}" class="flex justify-between">
                        @csrf
                        <input type="text" name="content" value="{{$post -> content}}"/>
                        <input type="submit" value="Modifier le post" class="border text-white bg-emerald-500 p-2 rounded-full cursor-pointer font-bold"/>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
