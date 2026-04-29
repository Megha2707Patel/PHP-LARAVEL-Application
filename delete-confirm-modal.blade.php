@props(['action', 'label' => 'Delete', 'message' => 'Are you sure? This action cannot be undone.'])

<div x-data="{ open: false }">
    <!-- Trigger -->
    <button @click="open = true"
            type="button"
            class="text-red-600 hover:text-red-800 text-sm font-medium transition">
        🗑 {{ $label }}
    </button>

    <!-- Backdrop + Modal -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
         @click.self="open = false">

        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <div class="text-center">
                <div class="text-5xl mb-4">⚠️</div>
                <h3 class="font-display text-xl font-bold text-stone-800 mb-2">Confirm Delete</h3>
                <p class="text-stone-500 text-sm mb-6">{{ $message }}</p>

                <div class="flex gap-3">
                    <button @click="open = false"
                            class="flex-1 px-4 py-2 border border-stone-300 rounded-lg text-stone-700 hover:bg-stone-50 transition text-sm font-medium">
                        Cancel
                    </button>

                    <form action="{{ $action }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
