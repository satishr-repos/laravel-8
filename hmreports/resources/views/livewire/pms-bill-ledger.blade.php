<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="w-auto p-5 border border-gray-100">
        <p class="text-base text-gray-700 font-semibold"> Select date and click button to generate PMS Bill Ledger Report</p>
        <form wire:submit.prevent="submit" class="flex flex-col">

            <div class="flex">
                <div class="mr-5">
                    <label for="start-date" class="input-label mt-4">Start Date</label>
                    <input type="date" id="start-date" class="input" wire:model.lazy="start_date">
                    @error('start_date') <span class="text-sm text-red-400 italic">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="end-date" class="input-label mt-4">End Date</label>
                    <input type="date" id="end-date" class="input" wire:model.lazy="end_date">
                    @error('end_date') <span class="text-sm text-red-400 italic">{{ $message }}</span> @enderror
                </div>
            </div>
           
            <button type="submit" value="submit" class="p-3 px-5 mt-4 bg-blue-400 text-white text-base rounded-lg  hover:bg-blue-700">
                <svg wire:loading class="animate-spin h-5 w-5 rounded-full bg-transparent border-2 border-transparent border-opacity-50 mr-4"style="border-right-color: white; border-top-color: white;" viewBox="0 0 24 24">
                    <!-- ... -->
                </svg>
                PMS Bill Ledger
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
