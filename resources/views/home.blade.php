@extends('layouts.app')

@section('content')

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('dashboard.groupsHeading') }}</div>

                    @if (empty($user->groups))
                        <div class="card-body">
                            <p>{{ trans('dashboard.emptyGroupsList') }}</p>
                        </div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($user->groups as $group)
                                <li class="list-group-item">{{ $group->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </main>

@endsection
