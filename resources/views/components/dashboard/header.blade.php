<div class="w-full">
    <header
        class="w-[81%] left-64 top-0 py-10 flex fixed items-center justify-between p-4 bg-white shadow-md z-50 px-9 pl-6 h-16">
        <div class="flex flex-col">
            <h1 class="font-semibold text-2xl text-amber-900">Administrator</h1>
        </div>

        <div class="flex items-center space-x-4">
            <div class="dropdown dropdown-end relative" x-data="{ open: false }">
                <div class="flex gap-3 items-center">
                    <div class="text-amber-800 font-medium">{{ Auth::user()->name }}</div>
                    <div @click="open = !open" tabindex="0" role="button"
                        class="relative flex items-center justify-center w-10 h-10 rounded-full bg-gray-600 text-white cursor-pointer hover:shadow-md transition-all duration-200">
                        <div
                            class="relative w-10 h-10 overflow-hidden  rounded-full border-2 border-white bg-[#422424] shadow-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strpos(Auth::user()->name, ' ') ? strtoupper(substr(Auth::user()->name, strpos(Auth::user()->name, ' ') + 1, 1)) : '' }}
                            </span>
                            <div class="absolute inset-0 bg-white opacity-10 rounded-full mix-blend-overlay"></div>
                        </div>
                    </div>
                </div>

                <ul x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform translate-y-2"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-lg z-[100] p-2 shadow-lg border border-amber-100"
                    style="display: none;">

                    <div class="border-t border-amber-100 my-1"></div>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full text-left text-amber-900 hover:bg-amber-50 rounded-md px-4 py-2 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>
</div>
