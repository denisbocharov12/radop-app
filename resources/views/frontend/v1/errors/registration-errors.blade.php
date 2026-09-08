{{-- Registration renders field errors inline; only these two form-level
     failures need announcing at the top of the page. --}}
@php
    $formErrors = collect(['duplicated_email', 'type_not_found'])
        ->filter(fn ($key) => $errors->has($key))
        ->map(fn ($key) => $errors->first($key));
@endphp

@if($formErrors->isNotEmpty())
    <div class="mt-4 rounded-lg border border-danger-500/30 bg-danger-50 p-4" role="alert">
        <ul class="space-y-1 text-sm text-danger-600">
            @foreach($formErrors as $message)
                <li class="flex items-start gap-2">
                    <x-sf-icon name="info" :size="15" class="mt-0.5 shrink-0" />
                    <span>{{ $message }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
