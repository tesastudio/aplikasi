@if(!empty(session('success')))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(!empty(session('error')))
<div class="alert alert-danger" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(!empty(session('payment error')))
<div class="alert alert-danger" role="alert">
    {{ session('payment error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(!empty(session('warning')))
<div class="alert alert-warning" role="alert">
    {{ session('warning') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(!empty(session('info')))
<div class="alert alert-info" role="alert">
    {{ session('info') }} 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(!empty(session('secondary')))
<div class="alert alert-secondary" role="alert">
    {{ session('secondary') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(!empty(session('primary')))
<div class="alert alert-primary" role="alert">
    {{ session('primary') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(!empty(session('light')))
<div class="alert alert-light" role="alert">
    {{ session('light') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif