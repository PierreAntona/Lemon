<div class="flex flex-col items-center px-4 md:items-start border-r pr-14">
    <a href="{{ route('dashboard') }}">
        <x-application-logo />
    </a>
    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-4 py-3 rounded-lg hover:bg-gray-100 cursor-pointer transition-all duration-200 group max-w-fit">
        <x-heroicon-o-home class="h-6 w-6" />
        <p class="group-hover:text-emerald-500 hidden md:inline-flex text-base lg:text-xl">Accueil</p>
    </a>

    <a href="{{ route('profil', Auth::user()->name) }}" class="flex items-center space-x-2 px-4 py-3 rounded-lg hover:bg-gray-100 cursor-pointer transition-all duration-200 group max-w-fit">
        <x-heroicon-o-user class="h-6 w-6" />
        <p class="group-hover:text-emerald-500 hidden md:inline-flex text-base lg:text-xl">Profil</p>
    </a>

    <a href="{{ route('notif', Auth::user()->name) }}" class="flex items-center space-x-2 px-4 py-3 rounded-lg hover:bg-gray-100 cursor-pointer transition-all duration-200 group max-w-fit">
        <x-heroicon-o-bell class="h-6 w-6" />
        <p class="group-hover:text-emerald-500 hidden md:inline-flex text-base lg:text-xl">Notifications</p>
    </a>

    <a href="" class=" flex items-center space-x-2 px-4 py-3 rounded-lg hover:bg-gray-100 cursor-pointer transition-all duration-200 group max-w-fit">
        <x-heroicon-o-chat class="h-6 w-6" />
        <p class="group-hover:text-emerald-500 hidden md:inline-flex text-base lg:text-xl">Messages</p>
    </a>

    <a href="" class=" flex items-center space-x-2 px-4 py-3 rounded-lg hover:bg-gray-100 cursor-pointer transition-all duration-200 group max-w-fit">
        <x-heroicon-o-cog class="h-6 w-6" />
        <p class="group-hover:text-emerald-500 hidden md:inline-flex text-base lg:text-xl">Paramètres</p>
    </a>

    <form method="POST" action="{{ route('logout') }}" class=" text-red-600 flex rounded-lg hover:bg-gray-100 cursor-pointer transition-all duration-200 group max-w-fit">
        @csrf
        <a class="flex items-center px-4 py-3 space-x-2 " :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
            <x-heroicon-o-logout class="h-6 w-6" />
            <p class=" hidden md:inline-flex text-base lg:text-xl">Déconnexion</p>
        </a>
    </form>
</div>