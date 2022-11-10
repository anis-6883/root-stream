<form method="post" class="ajax-submit" autocomplete="off" action="{{ route('sports_types.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">{{ _lang('Sports Name') }}</label>
                <input type="text" class="form-control" name="sports_name" value="{{ old('sports_name') }}" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">{{ _lang('Sports SKQ') }}</label>
                <input type="text" class="form-control" name="sports_skq" data-random="{{ Str::random(8) }}" readonly required>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="mb-3">
                <label class="form-label">{{ _lang('Status') }}</label>
                <select class="form-control select2" name="status" required>
                    <option value="1">{{ _lang('Active') }}</option>
                    <option value="0">{{ _lang('In-Active') }}</option>
                </select>
            </div>
        </div>

        <div class="col-sm-12 mt-2">
            <div class="mb-3">
                <button type="reset" class="btn btn-danger btn-sm">{{ _lang('Reset') }}</button>
                <button type="submit" class="btn btn-primary btn-sm">{{ _lang('Save') }}</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $('[name=sports_name]').on('keyup', function() {
        $('[name=sports_skq]').val($(this).val().replace(/\s/g, '') + '_' + $('[name=sports_skq]').data('random'))
    });
</script>

