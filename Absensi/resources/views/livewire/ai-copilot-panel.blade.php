<div class="fixed bottom-6 right-6 z-50">
    <!-- Floating Button -->
    @if (!$isOpen)
        <button
            wire:click="togglePanel"
            class="flex items-center justify-center w-14 h-14 rounded-full bg-linear-to-br from-emerald-500 to-emerald-600 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105 group"
            title="Buka Asisten AI"
        >
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
            </svg>
            <span class="absolute w-3 h-3 bg-red-500 rounded-full top-1 right-1 animate-pulse"></span>
        </button>
    @else
        <!-- Panel Container -->
        <div class="flex flex-col w-96 h-128 bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in slide-in-from-bottom-2 duration-300">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-linear-to-r from-emerald-50 to-teal-50 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-linear-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white text-sm font-semibold">
                        AI
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Asisten AI</h3>
                        <p class="text-xs text-gray-500">Siap membantu</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button
                        wire:click="minimizePanel"
                        class="p-2 hover:bg-white rounded-lg transition text-gray-600 hover:text-gray-900"
                        title="Minimize"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                    </button>
                    <button
                        wire:click="togglePanel"
                        class="p-2 hover:bg-white rounded-lg transition text-gray-600 hover:text-gray-900"
                        title="Close"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="flex-1 overflow-y-auto px-4 py-4 space-y-4 bg-linear-to-b from-white via-gray-50 to-gray-50">
                @foreach ($messages as $message)
                    @if ($message['type'] === 'user')
                        <!-- User Message -->
                        <div class="flex justify-end">
                            <div class="max-w-xs bg-emerald-600 text-white rounded-2xl rounded-tr-sm px-4 py-2.5 text-sm leading-relaxed shadow-sm">
                                {{ $message['content'] }}
                            </div>
                        </div>
                    @else
                        <!-- AI Message -->
                        <div class="flex justify-start">
                            <div class="max-w-xs bg-gray-100 text-gray-900 rounded-2xl rounded-tl-sm px-4 py-2.5 text-sm leading-relaxed shadow-sm">
                                {!! nl2br(e($message['content'])) !!}
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Input Area -->
            <div class="px-4 py-3 bg-white border-t border-gray-100">
                <form wire:submit="sendMessage" class="flex gap-2">
                    <input
                        type="text"
                        wire:model="userMessage"
                        placeholder="Tanya sesuatu..."
                        class="flex-1 px-4 py-2 bg-gray-50 border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                    />
                    <button
                        type="submit"
                        class="p-2 bg-emerald-600 text-white rounded-full hover:bg-emerald-700 transition-colors disabled:opacity-50"
                        :disabled="!userMessage.trim()"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5.951-1.429 5.951 1.429a1 1 0 001.169-1.409l-7-14z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>

@script
<script>
    // Smooth scroll to latest message
    Livewire.hook('morph.updated', () => {
        const messagesArea = document.querySelector('[wire\\:model="messages"]')?.closest('.overflow-y-auto');
        if (messagesArea) {
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }
    });
</script>
@endscript
