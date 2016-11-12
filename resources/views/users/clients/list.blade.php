<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
      <th>@lang('app.full_name')</th>
      <th>@lang('app.email')</th>
      <th>@lang('app.registration_date')</th>
      <th>@lang('app.status')</th>
      <th class="text-center">@lang('app.actions')</th>
    </thead>
    <tbody>
        @foreach ($clients as $client)
            <tr>
                <td>{{ $client->full_name() }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->created_at }}</td>
                <td>
                  <span class="label label-{{ $client->labelClass() }}">{{ trans("app.{$client->status}") }}</span>
                </td>
                <td class="text-center">
                    <button type="button" data-href="#" class="btn btn-round btn-primary btn-xs create-edit-modal"
                       title="@lang('app.edit_client')" data-toggle="tooltip" data-placement="top">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" data-href="#" 
                      class="btn btn-round btn-danger btn-xs btn-delete" 
                      data-confirm-text="@lang('app.are_you_sure_delete_client')"
                      data-confirm-delete="@lang('app.yes_delete_him')"
                      title="@lang('app.delete_client')" data-toggle="tooltip" data-placement="top">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
  {{ $clients->links() }}