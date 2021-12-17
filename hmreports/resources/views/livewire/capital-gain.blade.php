<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="w-auto p-5 border border-gray-100">
        <form wire:submit.prevent="submit" class="flex flex-col">

            <div>
                <label for="name" class="input-label">Name</label>
                <input type="text" id="name" class="input" wire:model.lazy="name">
                @error('name') <span class="text-sm text-red-400 italic">{{ $message }}</span> @enderror
            </div>
           
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
                Capital Gain
            </button>
        </form>
    </div>
    <div wire:loading>
        <p class="text-sm font-bold italic">Calculating gains....</p>
    </div>
    <div wire:loading.remove>
        <p class="text-sm text-red-400 italic">{{ $exception }}</p>
    </div>
</div>
