<x-app-layout>
    <div class="flex border-x justify-between">
        @include('components.sidebar')

        <div class=" w-full flex flex-col py-2">
            <div class="px-8 py-4 w-full flex justify-between items-center">
                <h1 class="px-4 text-2xl font-bold text-emerald-500">Recherche</h1>
                <form class="flex items-center" method="POST" action="{{route('search')}}">
                    <input type="text" name="search" class="rounded-full mr-3" placeholder="Recherche Lemon" />
                    @csrf
                    <x-heroicon-o-search class="w-8 h-8 text-emerald-500 cursor-pointer">
                        <input type="submit">
                    </x-heroicon-o-search>
                </form>
            </div>
            <div class="mx-6 border-b text-lg font-bold">
                <p>Utilisateurs</p>
            </div>

            @isset($result)
            @foreach($result as $oneResult)
            <div class="flex mx-6 mt-4" >
                <a href="{{ route('profil', $oneResult->name) }}"><img class="h-10 w-10 rounded-full object-cover mr-4" src='https://links.papareact.com/gll' alt="" /></a>
                <div class="w-full">
                    <div class="flex w-full justify-between items-center space-x-1">
                        <p class="mr-1 font-bold">{{ $oneResult->name }}</p>
                        <form action="">
                        @csrf
                            <input type="submit" class=" px-5 py-2 font-bold text-emerald-500 rounded-full border border-emerald-500 cursor-pointer" value="Suivre" />
                        </form>

                    </div>
                </div>
            </div>
            @endforeach
            @endisset

            @empty($result)
            <div>
                <p>Aucun utilisateur trouvé.</p>
            </div>
            @endempty
        </div>
    </div>
</x-app-layout>