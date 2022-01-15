<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="w-auto p-5 border border-gray-100">
        <form wire:submit.prevent="save" class="flex items-center" >
            <div class="flex justify-center">
                <div class="mb-3 w-96">
                    <label for="formFile" class="form-label inline-block mb-2 text-gray-700">BSE Corporate Action File</label>
                    <input wire:model="corpActn" class="form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="formFile">
                    @error('corpActn') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <button class="ml-3 mt-4 px-7 h-11 bg-green-400 text-white text-base rounded-lg  hover:bg-green-700">
                <svg wire:loading wire:target="save" class="animate-spin h-5 w-5 rounded-full bg-transparent border-2 border-transparent border-opacity-50 mr-4"style="border-right-color: white; border-top-color: white;" viewBox="0 0 24 24">
                    <!-- ... -->
                </svg>
                Upload
            </button>
        </form>
        <form wire:submit.prevent="submit" class="flex flex-col">
            <button type="submit" value="submit" class="p-3 px-5 mt-4 bg-blue-400 text-white text-base rounded-lg  hover:bg-blue-700">
                <svg wire:loading wire:target="submit" class="animate-spin h-5 w-5 rounded-full bg-transparent border-2 border-transparent border-opacity-50 mr-4"style="border-right-color: white; border-top-color: white;" viewBox="0 0 24 24">
                    <!-- ... -->
                </svg>
                Generate
            </button>
        </form>
    </div>
    <div wire:loading wire:target="submit">
        <p class="text-sm font-bold italic">Generating...</p>
    </div>
    <div wire:loading.remove wire:target="submit">
        <p class="text-sm text-red-400 italic">{{ $exception }}</p>

        @isset($url)
            <h4 class="text-base mt-5 italic font-semibold">You can download the report from <a href="#" wire:click.prevent="Download" class="text-blue-500 italic underline font-semibold">here</a></h4>
        @endisset
    </div>
</div>
