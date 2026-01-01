<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showDeleteModal: false, deleteFormId: null, deleteSlug: null, open(formId, slug){ this.deleteFormId = formId; this.deleteSlug = slug; this.showDeleteModal = true }, cancel(){ this.showDeleteModal = false; this.deleteFormId = null; this.deleteSlug = null }, confirm(){ if(this.deleteFormId){ document.getElementById(this.deleteFormId).submit(); } }, passwordEnabled: {{ old('password_enabled') ? 'true' : 'false' }} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Shortened Links List -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Shortened Links</h3>
                        <ul>
                            <!-- Loop through shortened links -->
                            @foreach($links as $link)
                                <li class="mb-2 flex items-center justify-between">
                                    <div>
                                        <a href="{{ $link->slug }}" target="_blank" class="text-blue-500 hover:underline">
                                            {{ $link->slug }}
                                        </a>
                                        <span class="text-sm font-normal text-gray-500">
                                            ({{ $link->redirects_count }} {{ $link->redirects_count === 1 ? 'redirect' : 'redirects' }})
                                        </span>
                                        <p class="text-sm text-gray-500">Target: {{ $link->target }}</p>
                                        @if($link->expires_at)
                                            <p class="text-sm text-gray-500">Expires: {{ $link->expires_at->diffForHumans() }} @if($link->isExpired()) (expired) @endif</p>
                                        @else
                                            <p class="text-sm text-gray-500">Expires: Never</p>
                                        @endif
                                    </div>
                                    <div class="ml-2 flex items-center space-x-2">
                                        <span class="relative inline-flex items-center text-sm text-gray-600 dark:text-gray-300" aria-hidden="false">
                                            <span class="group inline-flex items-center">
                                                @if($link->isPasswordProtected())
                                                    <i class="fas fa-lock mr-2 text-yellow-600" aria-hidden="true"></i>
                                                @else
                                                    <i class="fas fa-unlock mr-2 text-green-600" aria-hidden="true"></i>
                                                @endif
                                                <span class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 scale-95 opacity-0 group-hover:opacity-100 group-hover:scale-100 transition-all duration-150 pointer-events-none whitespace-nowrap bg-gray-800 text-white text-xs rounded px-2 py-1 dark:bg-gray-700" role="tooltip">
                                                    {{ $link->isPasswordProtected() ? 'Password protection is ON' : 'Password protection is OFF' }}
                                                </span>
                                            </span>
                                        </span>
                                        <a href="{{ route('links.edit', $link) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-2 rounded text-sm">Edit</a>
                                        <form id="delete-form-{{ $link->id }}" action="{{ route('links.destroy', $link) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click.prevent="open('delete-form-{{ $link->id }}','{{ $link->slug }}')" class="bg-red-600 hover:bg-red-800 text-white font-bold py-1 px-2 rounded text-sm">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        {{ $links->links() }}
                    </div>
                </div>
            </div>
             <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Create Shortened Link Form -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Create New Shortened Link</h3>

                        @if($links->total() >= 20)
                            <div class="p-4 border border-yellow-300 bg-yellow-50 rounded">
                                <p class="text-sm text-yellow-800">You have reached the maximum of 20 links. Delete some existing links to create new ones.</p>
                            </div>
                        @else
                            <form action="{{ route('links.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="target" class="block text-gray-700 dark:text-gray-300">URL to shorten</label>
                                    <input type="url" id="target" name="target" required class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:text-gray-800 rounded-lg" value="{{ old('target') }}">
                                    @error('target')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="slug" class="block text-gray-700 dark:text-gray-300">Custom URL (optional)</label>
                                    <input type="text" id="slug" name="slug" placeholder="Leave blank for random" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:text-gray-800 rounded-lg" value="{{ old('slug') }}">
                                    <p class="text-xs text-gray-500 mt-1">Only letters, numbers, dashes, and underscores allowed</p>
                                    @error('slug')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="expires_at" class="block text-gray-700 dark:text-gray-300">Expiration (optional)</label>
                                    <input type="text" id="expires_at" name="expires_at" placeholder="Select date and time" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:text-gray-800 rounded-lg" value="{{ old('expires_at') }}">
                                    <p class="text-xs text-gray-500 mt-1">Leave blank to use default 90-day expiry.</p>
                                    @error('expires_at')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <label class="inline-flex items-center mt-2">
                                        <input type="checkbox" name="never" value="1" class="form-checkbox mr-2" {{ old('never') ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Never expire</span>
                                    </label>
                                </div>

                                <div class="mb-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="password_enabled" value="1" class="form-checkbox mr-2" x-model="passwordEnabled">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Password protect</span>
                                    </label>
                                    <div class="mt-2" x-cloak x-show="passwordEnabled">
                                        <label for="password" class="block text-gray-700 dark:text-gray-300">Password</label>
                                        <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:text-gray-800 rounded-lg">
                                        @error('password')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Shorten URL
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Delete confirmation modal -->
            <div x-cloak x-show="showDeleteModal" class="fixed inset-0 flex items-center justify-center z-50">
                <div class="fixed inset-0 bg-black opacity-50" @click="cancel()"></div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-lg w-full mx-4 p-6 z-50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Confirm deletion</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Are you sure you want to delete <span class="font-medium text-gray-800 dark:text-gray-100" x-text="deleteSlug"></span>? This action cannot be undone.</p>
                    <div class="mt-4 flex justify-end space-x-2">
                        <button @click="cancel()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">Cancel</button>
                        <button @click="confirm()" class="bg-red-600 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded">Yes, delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>