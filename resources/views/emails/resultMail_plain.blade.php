LaraWebCron detail for:

task name: {{ $emailData->name }},
result ID: {{ $emailData->id }},
date/time of execution: {{ $emailData->updated_at }},
duration: {{ $emailData->duration }},
return code: {{ $emailData->code }},
tasks url: {{ $emailData->url }}

Task's body result:
{{ $emailData->body }}

