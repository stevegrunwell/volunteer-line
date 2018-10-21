@extends('layouts.app')

@section('title', trans('group.edit.pageTitle'))

@section('content')

    <main class="container">
        <h1>{{ trans('group.edit.pageTitle') }}</h1>

        <form method="post" action="{{ route('group.update', ['group' => $group]) }}">
            @include('messages')
            @include('group.form', ['group' => $group])

            {{ method_field('PUT') }}
            <input type="submit" value="{{ trans('group.edit.saveButton') }}" class="btn btn-primary" />
        </form>
    </main>

@endsection
