@extends('layouts.app')

@section('page-title', trans('app.users'))

@section('content')

<div class="right_col" role="main">
  <div class="">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="page-title">
            <div class="title_left">
              <h3>@lang('app.users')</h3>
            </div>
            <div>
              <div class="col-md-6 col-sm-7 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" id="search" class="form-control" placeholder="@lang('app.write_here')">
                  <span class="input-group-btn">
                    <button class="btn btn-default search" type="button">@lang('app.search')</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        
          <div class="x_content">
            <p>
            <button type="button" data-href="{{ route('user.create') }}" class="btn btn-primary btn-sm create-edit-modal" title="@lang('app.create_user')">@lang('app.create_user')</button>
            </p>

            <div id="content-table">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <th>@lang('app.full_name')</th>
                  <th>@lang('app.email')</th>
                  <th>@lang('app.role')</th>
                  <th>@lang('app.registration_date')</th>
                  <th>@lang('app.status')</th>
                  <th class="text-center">@lang('app.actions')</th>
                </thead>
                <tbody>
                @if (count($users))
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->full_name() }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role->display_name }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                              <span class="label label-{{ $user->labelClass() }}">{{ trans("app.{$user->status}") }}</span>
                            </td>
                            <td class="text-center">
                                <button type="button" data-href="{{ route('user.edit', $user->id) }}" class="btn btn-round btn-primary btn-xs create-edit-modal"
                                   title="@lang('app.edit_user')" data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" data-href="{{ route('user.destroy', $user->id) }}" 
                                  class="btn btn-round btn-danger btn-xs btn-delete" 
                                  data-confirm-text="@lang('app.are_you_sure_delete_user')"
                                  data-confirm-delete="@lang('app.yes_delete_him')"
                                  title="@lang('app.delete_user')" data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4"><em>@lang('app.no_records_found')</em></td>
                    </tr>
                @endif
                </tbody>
              </table>
              {{ $users->links() }}
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

@endsection