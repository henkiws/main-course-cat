@extends('layouts.main')

@section('content')
 <!--begin::App Content Header-->
 <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Roles</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Roles</li>
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

              <div class="card-tools">
                {{-- <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">Add New Role</a> --}}
              </div>
            </div>
            <!-- /.card-header -->
            <form method="GET" class="">
              <div class="row p-2">
                  <div class="col-sm-6 col-md-6">
                      <label for="show">Show: </label>
                      <select name="show" id="show">
                        <option {{ request()->get('show') == 10 ? "selected" : "" }} value="10">10</option>
                        <option {{ request()->get('show') == 20 ? "selected" : "" }} value="20">20</option>
                        <option {{ request()->get('show') == 50 ? "selected" : "" }} value="50">50</option>
                        <option {{ request()->get('show') == 100 ? "selected" : "" }} value="100">100</option>
                      </select>
                  </div>
                  <div class="col-sm-6 col-md-6 flex">
                      <input type="text" class="form-control form-control-sm" id="search" name="q" style="width: 200px" value="{{ request()->get('q') }}">&nbsp;
                      <button type="submit" class="btn btn-sm btn-default">Search</button>
                  </div>
              </div>
            </form>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    {{-- <th>Action</th> --}}
                  </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $val)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $val->name }}</td>
                            {{-- <td>
                                <a href="edit_user.php?id=1" class="btn btn-warning btn-sm btn-equal">
                                    <i class="fas fa-edit"></i> 
                                </a>
                                <a href="delete_user.php?id=1" class="btn btn-danger btn-sm btn-equal" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    <i class="fas fa-trash"></i> 
                                </a>
                            </td> --}}
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