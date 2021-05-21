<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Task
        </h2>
    </x-slot>

    <div>
        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form method="post" action="{{ route('webcrontasks.update', $webcrontask->id) }}">
                    {{-- <form method="post" action="{{ route('webcrontasks.update', ['webcrontask'=>$webcrontask->id]) }}"> --}}
                    {{-- <form method="post" action="/webcrontasks/19"> --}}
                    @csrf
                    @method('PUT')
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="enabled" class="block font-medium text-sm text-gray-700">Status:</label>
                            <select id="enabled" name="enabled" autocomplete="enabled" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="1" @php if ($webcrontask->enabled) echo "selected"; @endphp >Enabled</option>
                                <option value="0" @php if (!$webcrontask->enabled) echo "selected"; @endphp >Disabled</option>
                              </select>

                            <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                            <input type="text" name="name" id="name" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('name', $webcrontask->name) }}"  required />
                            @error('name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <label for="url" class="block font-medium text-sm text-gray-700">Url</label>
                            <input type="text" name="url" id="url" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('url', $webcrontask->url) }}"  required />
                            @error('url')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <label for="site" class="block font-medium text-sm text-gray-700">Site</label>
                            <input type="text" name="site" id="site" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('site', $webcrontask->site) }}" />
                            @error('site')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <label for="schedule" class="block font-medium text-sm text-gray-700">Schedule</label>
                            <input placeholder="* * * * *" type="text" name="schedule" id="schedule" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('schedule', $webcrontask->schedule) }}"  required/>
                                   @error('schedule')
                                   <p class="text-sm text-red-600">{{ $message }}</p>
                                   <div class="text-sm text-gray-600">
                                   <p>A CRON expression is a string representing the schedule for a particular command to execute.  The parts of a CRON schedule are as follows:</p>
                                   <pre><code>
   *    *    *    *    *
   -    -    -    -    -
   |    |    |    |    |
   |    |    |    |    |
   |    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
   |    |    |    +---------- month (1 - 12)
   |    |    +--------------- day of month (1 - 31)
   |    +-------------------- hour (0 - 23)
   +------------------------- min (0 - 59)
                                   </code></pre>
                                   <p>This system also supports a few macros:</p>
                                   <ul>
                                   <li><code>@yearly</code>, <code>@annually</code> - Run once a year, midnight, Jan. 1 - <code>0 0 1 1 *</code></li>
                                   <li><code>@monthly</code> - Run once a month, midnight, first of month - <code>0 0 1 * *</code></li>
                                   <li><code>@weekly</code> - Run once a week, midnight on Sun - <code>0 0 * * 0</code></li>
                                   <li><code>@daily</code> - Run once a day, midnight - <code>0 0 * * *</code></li>
                                   <li><code>@hourly</code> - Run once an hour, first minute - <code>0 * * * *</code></li>
                                   </ul>
                               </div>
                               @enderror

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-8 mt-5 mx-7">
                                <div class="grid grid-cols-1">
                                    <label for="timeout" class="block font-medium text-sm text-gray-700">Timeout (in seconds)</label>
                                    <input placeholder="60" type="text" name="timeout" id="timeout" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                           value="{{ old('timeout', $webcrontask->timeout) }}"  required/>
                                    @error('timeout')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1">
                                    <label for="attempts" class="block font-medium text-sm text-gray-700">Attempts (in seconds)</label>
                                    <input placeholder="1" type="text" name="attempts" id="attempts" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                           value="{{ old('attempts', $webcrontask->attempts) }}"  required/>
                                    @error('attempts')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1">
                                    <label for="retry_waits" class="block font-medium text-sm text-gray-700">Retry waits (in milliseconds)</label>
                                    <input placeholder="5000" type="text" name="retry_waits" id="retry_waits" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                           value="{{ old('retry_waits', $webcrontask->retry_waits) }}"  required/>
                                    @error('url')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                              </div>

                            {{-- <label for="timeout" class="block font-medium text-sm text-gray-700">timeout (in seconds)</label>
                            <input placeholder="60" type="text" name="timeout" id="timeout" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('timeout', $webcrontask->timeout) }}"  required/>
                            @error('timeout')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <label for="attempts" class="block font-medium text-sm text-gray-700">attempts (in seconds)</label>
                            <input placeholder="1" type="text" name="attempts" id="attempts" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('attempts', $webcrontask->attempts) }}"  required/>
                            @error('attempts')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <label for="retry_waits" class="block font-medium text-sm text-gray-700">retry_waits (in milliseconds)</label>
                            <input placeholder="5000" type="text" name="retry_waits" id="retry_waits" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('retry_waits', $webcrontask->retry_waits) }}"  required/>
                            @error('url')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror --}}

                            <label for="email" class="block font-medium text-sm text-gray-700">Email for log</label>
                            <input type="email" name="email" id="email" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('email', $webcrontask->email) }}" />
                            @error('email')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                                <div class="grid grid-cols-1">
                                    <label for="log_type" class="block font-medium text-sm text-gray-700">Log type:</label>
                                    <select id="log_type" name="log_type" autocomplete="log_type" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                        <option value="2" @php if ($webcrontask->log_type===2) echo "selected"; @endphp >Always</option>
                                        <option value="1" @php if ($webcrontask->log_type===1) echo "selected"; @endphp >Only with error</option>
                                        <option value="0" @php if ($webcrontask->log_type===0) echo "selected"; @endphp >Never</option>
                                      </select>
                                </div>
                                <div class="grid grid-cols-1">
                                    <label for="max_runs" class="block font-medium text-sm text-gray-700">Max runs (0 unlimited)</label>
                                    <input type="text" name="max_runs" id="max_runs" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                           value="{{ old('max_runs', $webcrontask->max_runs) }}" />
                                    @error('max_runs')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                              </div>





                              {{-- <label for="start_date" class="block font-medium text-sm text-gray-700">Start date</label>
                              <input type="date" name="start_date" id="start_date" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                     value="{{ old('start_date', $webcrontask->start_date) }}" />
                              @error('start_date')
                                  <p class="text-sm text-red-600">{{ $message }}</p>
                              @enderror

                              <label for="end_date" class="block font-medium text-sm text-gray-700">End date</label>
                              <input type="date" name="end_date" id="end_date" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                     value="{{ old('end_date', $webcrontask->end_date) }}" />
                              @error('end_date')
                                  <p class="text-sm text-red-600">{{ $message }}</p>
                              @enderror --}}

                              <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                                <div class="grid grid-cols-1">
                                    <label for="start_date" class="block font-medium text-sm text-gray-700">Start date</label>
                                    <input type="date" name="start_date" id="start_date" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                           value="{{ old('start_date', $webcrontask->start_date) }}" />
                                    @error('start_date')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1">
                                    <label for="end_date" class="block font-medium text-sm text-gray-700">End date</label>
                                    <input type="date" name="end_date" id="end_date" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                           value="{{ old('end_date', $webcrontask->end_date) }}" />
                                    @error('end_date')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- <h1><a id="user-content-cron-expressions" class="anchor" href="#user-content-cron-expressions" rel="nofollow noindex noopener external ugc"></a>CRON Expressions</h1>
                                <p>A CRON expression is a string representing the schedule for a particular command to execute.  The parts of a CRON schedule are as follows:</p>
                                <pre><code>
                                *    *    *    *    *
                                -    -    -    -    -
                                |    |    |    |    |
                                |    |    |    |    |
                                |    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
                                |    |    |    +---------- month (1 - 12)
                                |    |    +--------------- day of month (1 - 31)
                                |    +-------------------- hour (0 - 23)
                                +------------------------- min (0 - 59)
                                </code></pre>
                                <p>This library also supports a few macros:</p>
                                <ul>
                                <li><code>@yearly</code>, <code>@annually</code> - Run once a year, midnight, Jan. 1 - <code>0 0 1 1 *</code></li>
                                <li><code>@monthly</code> - Run once a month, midnight, first of month - <code>0 0 1 * *</code></li>
                                <li><code>@weekly</code> - Run once a week, midnight on Sun - <code>0 0 * * 0</code></li>
                                <li><code>@daily</code> - Run once a day, midnight - <code>0 0 * * *</code></li>
                                <li><code>@hourly</code> - Run once an hour, first minute - <code>0 * * * *</code></li>
                                </ul> --}}








                        </div>





                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


