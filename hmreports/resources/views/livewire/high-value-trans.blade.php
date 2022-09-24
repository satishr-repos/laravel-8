<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="w-auto p-5 border border-gray-100">
        <p class="text-base text-gray-700 font-semibold">Enter Strategy Name and Client Name to generate report</p>
        <form wire:submit.prevent="submit" class="flex flex-col">

            <div class="flex">
                <div class="mr-5">
                    <label for="strategy" class="input-label mt-4">Strategy Name</label>
                    <input type="text" id="strategy" class="input" wire:model.lazy="strategy">
                    @error('strategy') <span class="text-sm text-red-400 italic">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="client" class="input-label mt-4">Client Name</label>
                    <input type="text" id="client" class="input" wire:model.lazy="client">
                    @error('client') <span class="text-sm text-red-400 italic">{{ $message }}</span> @enderror
                </div>
            </div>
           
            <button type="submit" value="submit" class="p-3 px-5 mt-4 bg-blue-400 text-white text-base rounded-lg  hover:bg-blue-700">
                <svg wire:loading class="animate-spin h-5 w-5 rounded-full bg-transparent border-2 border-transparent border-opacity-50 mr-4"style="border-right-color: white; border-top-color: white;" viewBox="0 0 24 24">
                    <!-- ... -->
                </svg>
                High Value Transations
            </button>
        </form>
    </div>
    <div wire:loading>
        <p class="text-sm font-bold italic">Calculating ....</p>
    </div>
    <div wire:loading.remove>
        <p class="text-sm text-red-400 italic">{{ $exception }}</p>

        @isset($url)
            <h4 class="text-base mt-5 italic font-semibold">You can download the report from <a href="#" wire:click.prevent="Download" class="text-blue-500 italic underline font-semibold">here</a></h4>
        @endisset
    </div>
</div>
