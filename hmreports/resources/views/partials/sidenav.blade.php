<div class="flex flex-col top-0 left-0 max-w-none h-full w-auto bg-white" id="sidebar">

  <div class="flex flex-row items-center h-14 ">
    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-12 ml-4" />
    <div class="text-blue-700 font-semibold font-serif ml-3 uppercase">
      <span>Harmoney FinServ</span>
    </div>
  </div>

  <div class="overflow-y-auto overflow-x-hidden flex-grow">
    <ul class="flex flex-col py-4 space-y-1">
      <li class="px-5">
        <div class="flex flex-row items-center h-8">
          <div class="text-sm font-light tracking-wide text-gray-500">Menu</div>
        </div>
      </li>
      <li>
        <a href="{{ route('capitalgain') }}" class="relative flex flex-row items-center h-11 focus:outline-none text-gray-600 hover:text-gray-800 pr-6 ml-4">
          <div class="inline-flex items-end border-b-2 pb-1 transform ease-in-out duration-300 hover:border-red-500 {{ $selection == 'capital-gain'? 'border-red-500' : 'border-transparent'}}">
            <span class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" /></svg>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate">Capital Gain Calculator</span>
          </div>
        </a>
      </li>
    </ul>
  </div>

</div>