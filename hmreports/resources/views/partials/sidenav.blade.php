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
          <div class="inline-flex items-end border-b-2 pb-1 transform ease-in-out duration-300 hover:border-green-500 {{ $selection == 'capital-gain'? 'border-red-500' : 'border-transparent'}}">
            <span class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate font-semibold">Capital Gain Calculator</span>
          </div>
        </a>
      </li>
      <li>
        <a href="{{ route('shareprorecon') }}" class="relative flex flex-row items-center h-11 focus:outline-none text-gray-600 hover:text-gray-800 pr-6 ml-4">
          <div class="inline-flex items-end border-b-2 pb-1 transform ease-in-out duration-300 hover:border-green-500 {{ $selection == 'sharepro-recon'? 'border-red-500' : 'border-transparent'}}">
            <span class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate font-semibold">SharePro Quantity Reconciliation</span>
          </div>
        </a>
      </li>
      <li>
        <a href="{{ route('corpactnnse') }}" class="relative flex flex-row items-center h-11 focus:outline-none text-gray-600 hover:text-gray-800 pr-6 ml-4">
          <div class="inline-flex items-end border-b-2 pb-1 transform ease-in-out duration-300 hover:border-green-500 {{ $selection == 'corp-actn-nse'? 'border-red-500' : 'border-transparent'}}">
            <span class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate font-semibold">Corporate Action NSE</span>
          </div>
        </a>
      </li>
      <li>
        <a href="{{ route('corpactnbse') }}" class="relative flex flex-row items-center h-11 focus:outline-none text-gray-600 hover:text-gray-800 pr-6 ml-4">
          <div class="inline-flex items-end border-b-2 pb-1 transform ease-in-out duration-300 hover:border-green-500 {{ $selection == 'corp-actn-bse'? 'border-red-500' : 'border-transparent'}}">
            <span class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate font-semibold">Corporate Action BSE</span>
          </div>
        </a>
      </li>
      <li>
        <a href="{{ route('pmsfeesrecon') }}" class="relative flex flex-row items-center h-11 focus:outline-none text-gray-600 hover:text-gray-800 pr-6 ml-4">
          <div class="inline-flex items-end border-b-2 pb-1 transform ease-in-out duration-300 hover:border-green-500 {{ $selection == 'pms-fees-recon'? 'border-red-500' : 'border-transparent'}}">
            <span class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate font-semibold">PMS Fees Reconciliation</span>
          </div>
        </a>
      </li>
      <li>
        <a href="{{ route('pmsbillledger') }}" class="relative flex flex-row items-center h-11 focus:outline-none text-gray-600 hover:text-gray-800 pr-6 ml-4">
          <div class="inline-flex items-end border-b-2 pb-1 transform ease-in-out duration-300 hover:border-green-500 {{ $selection == 'pms-bill-ledger'? 'border-red-500' : 'border-transparent'}}">
            <span class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate font-semibold">PMS Bill Ledger Report</span>
          </div>
        </a>
      </li>
      <li>
        <a href="{{ route('tradejinibrokerage') }}" class="relative flex flex-row items-center h-11 focus:outline-none text-gray-600 hover:text-gray-800 pr-6 ml-4">
          <div class="inline-flex items-end border-b-2 pb-1 transform ease-in-out duration-300 hover:border-green-500 {{ $selection == 'tradejini-brokerage'? 'border-red-500' : 'border-transparent'}}">
            <span class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate font-semibold">TradeJini Brokerage File</span>
          </div>
        </a>
      </li>
      <li>
        <a href="{{ route('orbiscustodyfile') }}" class="relative flex flex-row items-center h-11 focus:outline-none text-gray-600 hover:text-gray-800 pr-6 ml-4">
          <div class="inline-flex items-end border-b-2 pb-1 transform ease-in-out duration-300 hover:border-green-500 {{ $selection == 'orbis-custody-file'? 'border-red-500' : 'border-transparent'}}">
            <span class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" /></svg>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate font-semibold">Orbis Custody File</span>
          </div>
        </a>
      </li>
      <li>
        <a href="{{ route('highvaluetrans') }}" class="relative flex flex-row items-center h-11 focus:outline-none text-gray-600 hover:text-gray-800 pr-6 ml-4">
          <div class="inline-flex items-end border-b-2 pb-1 transform ease-in-out duration-300 hover:border-green-500 {{ $selection == 'high-value-trans'? 'border-red-500' : 'border-transparent'}}">
            <span class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate font-semibold">High Value Transations</span>
          </div>
        </a>
      </li>
    </ul>
  </div>

</div>