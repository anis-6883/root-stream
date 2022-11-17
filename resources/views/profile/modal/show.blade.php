<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="2" class="text-center">
                <img src="{{ asset($profile->image) }}" class="img-lg img-thumbnail">
            </td>
        </tr>
        <tr>
            <td>{{ _lang('Name') }}</td>
            <td>{{ $profile->name }}</td>
        </tr>
        <tr>
            <td>{{ _lang('Email') }}</td>
            <td>{{ $profile->email }}</td>
        </tr>
        <tr>
            <td>{{ _lang('Status') }}</td>
            <td>
                @if($profile->status)
                    <span class="badge rounded-pill border border-success text-success">Active</span>
				@else
				    <span class="badge rounded-pill border border-danger text-danger">In-Active</span>
				@endif
            </td>
        </tr>
    </tbody>
</table>

