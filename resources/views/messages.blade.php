{{-- Success messages. --}}
@if (session()->has('success'))
    <div class="alert alert-success" role="alert">
        <p class="mb-0">{{ session('success') }}</p>
    </div>
@endif


{{-- Display validation errors. --}}
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="list-unstyled mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
