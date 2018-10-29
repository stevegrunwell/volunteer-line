@extends('layouts.app')

@section('title', trans('group.edit.pageTitle'))

@section('content')

    <main class="container">
        <h1>{{ trans('group.edit.pageTitle') }}</h1>

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="true">{{ trans('group.edit.tabs.settings') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="members-tab" data-toggle="tab" href="#members" role="tab" aria-controls="members" aria-selected="true">{{ trans('group.edit.tabs.members') }}</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <form method="post" action="{{ route('group.update', ['group' => $group]) }}" class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                @include('messages')
                @include('group.form', ['group' => $group])

                {{ method_field('PUT') }}
                <input type="submit" value="{{ trans('group.edit.saveButton') }}" class="btn btn-primary" />
            </form>

            <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                <table class="table">
                    <thead>
                        <th>{{ trans('group.edit.members.nameHeading') }}</th>
                        <th>{{ trans('group.edit.members.phoneNumberHeading') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($group->users as $user)
                            <tr>
                                <td>
                                    {{ $user->displayName }}
                                    @if ($user->id === auth()->user()->id)
                                        <span class="badge badge-primary">{{ trans('group.edit.members.you') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @unless (empty($user->phoneNumbers))
                                        <ul class="list-unstyled">
                                            @foreach ($user->phoneNumbers as $number)
                                                <li>{{ $number->number }}</li>
                                            @endforeach
                                        </ul>
                                    @endunless
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            </div>
        </div>



    </main>

@endsection
