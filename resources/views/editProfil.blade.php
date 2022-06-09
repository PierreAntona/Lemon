<x-app-layout>
    <div class="flex border-x justify-between">
        @include('components.sidebar')

        <div class=" w-full flex flex-col py-2">

            <div class="px-8 py-4 w-full flex justify-between items-center">
                <h1 class="px-4 text-2xl font-bold text-emerald-500">Profil</h1>
                <form class="flex items-center" method="POST" action="{{route('search')}}">
                    <input type="text" name="search" class="rounded-full mr-3" placeholder="Recherche Lemon" />
                    @csrf
                    <x-heroicon-o-search class="w-8 h-8 text-emerald-500 cursor-pointer">
                        <input type="submit">
                    </x-heroicon-o-search>
                </form>
            </div>
            @foreach($profil as $info)
            <div class="py-4 mx-6 text-lg font-bold flex flex-col">
                <div class="flex justify-start items-center">
                @if($info->photo)
                        <img src="{{url('storage/profil/'.$info->photo)}}" class="h-16 w-16 rounded-full object-cover mr-4" alt="" />
                        @else
                        <img src="https://links.papareact.com/gll" class="h-14 w-14 object-cover rounded-full mt-4" alt="" />
                        @endif
                    <p class="text-2xl">{{ Auth::user()->name }}</p>
                </div>
                <form method="POST" enctype="multipart/form-data" action="{{route('updateProfil', Auth::user()->name)}}" class="mt-5 flex justify-between">
                            @csrf
                            <label for="media" class="flex items-center mt-4">
                                Votre nouvelle photo
                                <x-heroicon-o-photograph class="w-8 h-8 text-gray-500 cursor-pointer ml-4 mr-4 hover:text-emerald-500" />
                                <input type="file" name="media" id="media" style="display: none;" />
                            </label>
                            <input type="submit" value="Modifier" class="text-emerald-500 cursor-pointer ml-2 mt-4 border border-emerald-500 p-2 rounded-lg" />
                </form>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>