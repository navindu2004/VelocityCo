<?php

use function Livewire\Volt\{state};

//

?>

<div>
    //tailwind chat window with chat icon
    <div class="fixed bottom-0 right-0 z-50">
        <div class="flex flex-col items-end">
            <div class="flex items center">
                <button wire:click="toggleChat" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
