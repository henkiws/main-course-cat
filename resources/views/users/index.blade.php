@extends('layouts.main')

@section('content')
 <!--begin::App Content Header-->
 <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Users</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
          </ol>
        </div>
      </div>
      <!--end::Row-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::App Content Header-->

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"></h3>

              @role('admin')
              <div class="card-tools">
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">Add New User</a>
              </div>
              @endrole
            </div>
            <!-- /.card-header -->
            <form method="GET" class="">
              <div class="row p-2">
                  <div class="col-sm-6 col-md-6">
                      <label for="show">Show: </label>
                      <select name="show" id="show">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                      </select>
                  </div>
                  <div class="col-sm-6 col-md-6 flex">
                      <input type="text" class="form-control form-control-sm" id="search" name="q" style="width: 200px">&nbsp;
                      <button type="submit" class="btn btn-sm btn-default">Search</button>
                  </div>
              </div>
            </form>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Group</th>
                    <th>Synced</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $val)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->name }}</td>
                            <td>
                                <span class="tag tag-success">{{ $val->roles->pluck("name")->first(); }}</span>
                            </td>
                            <td>
                                {{ $val->data_user_group->data_group->name??'' }}
                            </td>
                            <td>{!! $val->fk_cbt_user > 0 || $val->fk_cbt_student > 0 ? "<span class='badge bg-success'>Yes</span>" : "<span class='badge bg-danger'>No</span>" !!}</td>
                            <td>
                                @if( $val->roles->pluck("name")->first() != "admin" )
                                <a href="{{ route('users.edit',[$val->id]) }}" class="btn btn-warning btn-sm btn-equal">
                                    <i class="fas fa-edit"></i> 
                                </a>
                                <a href="{{ route('users.destroy',[$val->id]) }}" class="btn btn-danger btn-sm btn-equal" onclick="event.preventDefault();document.getElementById('form{{ $val->id }}').submit()">
                                    <i class="fas fa-trash"></i> 
                                </a>
                                <form id="form{{ $val->id }}" action="{{ route('users.destroy',[$val->id]) }}" method="POST" class="d-none">
                                  @csrf
                                  @method('delete')
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>

              <div class="pagination mt-3 justify-content-center">
                {{ $list->links('vendor.pagination.bootstrap-4') }}
              </div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection