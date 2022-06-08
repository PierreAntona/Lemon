<div class="flex space-x-2 p-5">
    <img src="https://links.papareact.com/gll" } class="h-14 w-14 object-cover rounded-full mt-4" alt="" />
    <div class="flex flex-1 items-center pl-2">
        <form method="POST" enctype="multipart/form-data" action="{{route('postMessage')}}" class="flex flex-1 flex-col">
            @csrf
            <input type="text" name="message" class="h-24 w-full text-xl outline-none placeholder:text-xl" placeholder="Quoi de neuf ?" />
            <div class="flex items-center mt-2">
                <div class="flex space-x-2 flex-1 text-emerald-500">
                    <label for="media" class="">
                        <x-heroicon-o-photograph class="w-5 h-5 cursor-pointer transition-transform duration-150 ease-out hover:scale-150" />
                        <input type="file" name="media" id="media" style="display: none;" />
                    </label>
                    <x-heroicon-o-search class="h-5 w-5" />
                    <x-heroicon-o-emoji-happy class="h-5 w-5" />
                    <x-heroicon-o-calendar class="h-5 w-5" />
                    <x-heroicon-o-location-marker class="h-5 w-5" />
                </div>

                <input type="submit" class="bg-emerald-500 px-5 py-2 font-bold text-white rounded-full cursor-pointer" value="Poster" />
            </div>
        </form>
    </div>
</div>