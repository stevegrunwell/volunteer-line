@extends('layouts.app')

@section('content')

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('messages')

                <div class="card">
                    <div class="card-header">{{ trans('dashboard.groupsHeading') }}</div>

                    @if (empty($user->groups))
                        <div class="card-body">
                            <p>{{ trans('dashboard.emptyGroupsList') }}</p>

                            <p class="mb-0">
                                <a href="{{ route('group.create') }}" class="btn btn-primary">{{ trans('dashboard.createFirstGroupBtn') }}</a>
                            </p>
                        </div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($user->groups as $group)
                                <li class="list-group-item">{{ $group->name }}</li>
                            @endforeach
                        </ul>

                        <p class="card-body mb-0">
                            <a href="{{ route('group.create') }}" class="btn btn-primary">{{ trans('dashboard.createGroupBtn') }}</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </main>

@endsection
