@php
    //use Lorisleiva\CronTranslator\CronTranslator;
    use App\LaraWebCronFunctions;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Result
        </h2>
    </x-slot>
    <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="block mb-8">
            <a href="{{ route('webcronresults.index') }}" class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded">Back to Results list</a>

            <a href="{{ route('webcrontasks.show',$webcronresult->web_cron_task_id) }}" class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded">Back to Task details</a>


        </div>
        <div class="flex flex-col bg-white">

            <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                @php
                    $webcrontask = $webcronresult->webcrontask()->first();
                @endphp
                <div class="p-4">
                    <h2 class="text-2xl ">
                        {{ $webcrontask->name}}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ $webcrontask->url}}
                    </p>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center p-2 rounded justify-between space-x-2">
                        <div class="space-x-2 truncate">
                            @if ($webcronresult->code>=300)
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="red" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                    <title>Task Result with errors</title>
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="green" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <title>Task Result OK</title>
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                </svg>
                            @endif
                        </div>

                        <div class="flex item-center justify-center">
                            @if ($webcrontask->email !="")
                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <a href="{{ route('webcronresults.sendresultemailbyid', $webcronresult->id) }}" class="text-blue-600 hover:text-blue-900 mb-2 mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <title>Email task {{ $webcronresult->id }} to {{$webcrontask->email}}</title>
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif

                            <div class="w-4 mr-2 ml-4 transform hover:text-purple-500 hover:scale-110">
                                <form class="inline-block" action="{{ route('webcronresults.destroy', $webcronresult) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button class="text-red-600 hover:text-red-900 mb-2 mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <title>Delete task {{ $webcronresult->id }}</title>
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Return code
                    </p>
                    <p>
                        {{$webcronresult->code}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Executed at
                    </p>
                    <p>
                        {{ $webcronresult->updated_at->toDateTimeString() }}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Duration seconds
                    </p>
                    <p>
                        {{$webcronresult->duration}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Body of return
                    </p>
                    <p>
                        {{$webcronresult->body}}
                    </p>
                </div>
                {{-- <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Attempts
                    </p>
                    <p>
                        {{$webcronresult->attempts}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Retry waits
                    </p>
                    <p>
                        {{$webcronresult->retry_waits}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Email Address
                    </p>
                    <p>
                        {{$webcronresult->email}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Log type
                    </p>
                    <p>
                        @switch($webcronresult->log_type)
                            @case(0)
                                Never
                                @break
                            @case(1)
                                Only with error
                                @break
                            @case(2)
                                Always
                                @break
                            @default
                                Not defined
                        @endswitch
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Max runs
                    </p>
                    <p>
                        {{$webcronresult->max_runs}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Start date
                    </p>
                    <p>
                        {{$webcronresult->start_date}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        End date
                    </p>
                    <p>
                        {{$webcronresult->end_date}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Id
                    </p>
                    <p>
                        {{$webcronresult->id}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Creation date/time
                    </p>
                    <p>
                        {{$webcronresult->created_at}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Updated date/time
                    </p>
                    <p>
                        {{$webcronresult->updated_at}}
                    </p>
                </div>
            </div>
        </div>
    </div> --}}

</x-app-layout>
