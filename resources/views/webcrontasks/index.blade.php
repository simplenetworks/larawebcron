@php
    //use Lorisleiva\CronTranslator\CronTranslator;
    use App\LaraWebCronFunctions;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tasks List
        </h2>
    </x-slot>

    <div>
        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">



            <div class="block mb-8">

                <div class="grid grid-cols-2 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                    <div >
                         <a href="{{ route('webcrontasks.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Task</a>
                    </div>
                    <div>
                        <form action="{{ route('webcrontasks.search') }}" method="GET">
                            @csrf
                            <input type="text" name="query" class="form-control" />
                            <input type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" value="Search" style="margin-top: 10px;" />
                        </form>
                    </div>

                </div>

            </div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        @sortablelink('id')
                                    </th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        @sortablelink('status')
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        @sortablelink('name')
                                    </th>
                                    <th scope="col" width="100" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        @sortablelink('enabled')
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        @sortablelink('schedule')
                                    </th>
                                    <th scope="col" width="200" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($webcrontasks as $webcrontask)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $webcrontask->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @switch($webcrontask->status)
                                                @case(0)
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                                        <title>Task enabled but with errors</title>
                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                                    </svg>
                                                    @break

                                                @case(1)
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="gray" class="bi bi-circle" viewBox="0 0 16 16">
                                                        <title>Task disabled or enabled but never executed</title>
                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                    </svg>
                                                    @break

                                                @case(2)
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="green" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                        <title>Task enabled and OK</title>
                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                                    </svg>
                                                    @break

                                                @default
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrows-fullscreen" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707zm4.344 0a.5.5 0 0 1 .707 0l4.096 4.096V11.5a.5.5 0 1 1 1 0v3.975a.5.5 0 0 1-.5.5H11.5a.5.5 0 0 1 0-1h2.768l-4.096-4.096a.5.5 0 0 1 0-.707zm0-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707zm-4.344 0a.5.5 0 0 1-.707 0L1.025 1.732V4.5a.5.5 0 0 1-1 0V.525a.5.5 0 0 1 .5-.5H4.5a.5.5 0 0 1 0 1H1.732l4.096 4.096a.5.5 0 0 1 0 .707z"/>
                                                    </svg>
                                            @endswitch

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $webcrontask->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $webcrontask->site }}</div>
                                          </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <form class="inline-block" action="{{ route('webcrontasks.changetaskenabled', $webcrontask) }}" method="POST">
                                                <input type="hidden" name="_method" value="PATCH">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                @if ($webcrontask->enabled)
                                                    <input type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" value="Enabled">
                                                @else
                                                    <input type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" value="Disabled">
                                                @endif
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $webcrontask->schedule }}</div>
                                            <div class="text-sm text-gray-500">
                                                @php
                                                   echo LaraWebCronFunctions::getTraslationOfCronExpression($webcrontask->schedule); //CronTranslator::translate($webcrontask->schedule);
                                                @endphp
                                            </div>

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex item-center justify-center">
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('webcrontasks.show', $webcrontask->id) }}" class="text-blue-600 hover:text-blue-900 mb-2 mr-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                            <title>Show task {{ $webcrontask->name }} details</title>
                                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('webcrontasks.edit', $webcrontask->id) }}" class="text-blue-600 hover:text-blue-900 mb-2 mr-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <title>Edit task {{ $webcrontask->name }}</title>
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <form class="inline-block" action="{{ route('webcrontasks.duplicatetask', $webcrontask) }}" method="POST">
                                                        <input type="hidden" name="_method" value="PATCH">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button class="text-red-600 hover:text-red-900 mb-2 mr-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                                                <title>Duplicate task {{ $webcrontask->name }}</title>
                                                                <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                                                                <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <form class="inline-block" action="{{ route('webcrontasks.destroy', $webcrontask) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button class="text-red-600 hover:text-red-900 mb-2 mr-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                <title>Delete task {{ $webcrontask->name }}</title>
                                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="flex-1 flex ml-2 mr-2 mt-2 mb-2">
                                {!! $webcrontasks->appends(\Request::except('page'))->render() !!}
                                {{-- {{ $webcrontasks->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
