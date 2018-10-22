<div class="form-group">
    <label for="name">{{ trans('group.form.name') }}</label>
    <input name="name" id="name" type="text" class="form-control" value="{{ $group->name }}" maxlength="255" required>
</div>

<div class="form-group">
    <label for="phone_numbers">{{ trans('group.form.phoneNumbers') }}</label>
    <textarea name="phone_numbers" id="phone_numbers" class="form-control" placeholder="+18008675309">{{ $group->phoneNumbers()->pluck('number')->implode(PHP_EOL) }}</textarea>
    <p class="form-text">{!! trans('group.form.phoneNumbersHelp') !!}</p>
</div>

{{ csrf_field() }}
