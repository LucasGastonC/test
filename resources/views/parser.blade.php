<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Parser') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<x-auth-validation-errors class="mb-4" :errors="$errors" />
                <div class="p-6 bg-white border-b border-gray-200">
	            	@if(session('status'))
						<x-auth-session-status class="mb-4" :status="session('status')" />
					@endif
                    <form method="POST" action="{{route('parser.parse')}}" enctype="multipart/form-data">
                    	@csrf
                    	<div>
			                <x-label for="file" :value="__('Archivo')" />

			                <x-input id="file" class="block mt-1 w-full" type="file" name="file" required autofocus />
			            </div>

			            <div class="flex items-center justify-end mt-4">
			            	<!-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('parser.limpiar') }}">
			                    {{ __('Limpiar BD') }}
			                </a> -->
			                <x-button class="ml-4">
			                    {{ __('Cargar') }}
			                </x-button>
			            </div>

                    </form>	
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
