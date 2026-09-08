@if($errors->any())
    <div class="mt-4 rounded-lg border border-danger-500/30 bg-danger-50 p-4" role="alert">
        <ul class="space-y-1 text-sm text-danger-600">
            @foreach($errors->all() as $error)
                <li class="flex items-start gap-2">
                    <x-sf-icon name="info" :size="15" class="mt-0.5 shrink-0" />
                    <span>{{ $error }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
