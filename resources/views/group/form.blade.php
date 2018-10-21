<div class="form-group">
    <label for="name">{{ trans('group.form.name') }}</label>
    <input name="name" id="name" type="text" class="form-control" value="{{ $group->name }}" maxlength="255" required>
</div>

{{ csrf_field() }}
