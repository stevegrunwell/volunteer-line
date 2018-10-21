@extends('layouts.app')

@section('title', trans('group.create.pageTitle'))

@section('content')

    <main class="container">
        <h1>{{ trans('group.create.pageTitle') }}</h1>
        <p class="lead">{{ trans('group.create.lead') }}</p>

        <form method="post" action="{{ route('group.store') }}">
            @include('messages')
            @include('group.form', ['group' => $group])

            <input type="submit" value="{{ trans('group.create.saveButton') }}" class="btn btn-primary" />
        </form>
    </main>

@endsection
