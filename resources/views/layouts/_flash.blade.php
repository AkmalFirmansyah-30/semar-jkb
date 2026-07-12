{{-- Flash Messages: success, error, warning, info --}}
@foreach(['success' => 'alert-success', 'error' => 'alert-danger', 'warning' => 'alert-warning', 'info' => 'alert-info'] as $type => $class)
    @if(session($type))
        <div class="alert {{ $class }} alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            @if($type === 'success')
                <i class="bi bi-check-circle-fill me-2"></i>
            @elseif($type === 'error')
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
            @elseif($type === 'warning')
                <i class="bi bi-exclamation-circle-fill me-2"></i>
            @else
                <i class="bi bi-info-circle-fill me-2"></i>
            @endif
            {{ session($type) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
@endforeach

{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
