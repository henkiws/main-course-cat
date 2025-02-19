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
            <li class="breadcrumb-item"><a href="{{ route('cert.index') }}">Certificates</a></li>
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
              <h3 class="card-title">
                Cert: <b>{{ $cert->title }}</b>
              </h3>
              
              {{-- @role('admin')
              <div class="card-tools">
                <a href="{{ route('cert.create') }}" class="btn btn-sm btn-primary">Generate Certificate</a>
              </div>
              @endrole --}}
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
                    <th>Email</th>
                    <th>CBT</th>
                    <th>Generated Cert?</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $val)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $val->name }}</td>
                            <td>{{ $val->email }}</td>
                            <td>
                              @php
                                $toArray = json_decode($cert->details);
                                $btn_show = true;
                                print '<ul>';
                                foreach($toArray as $k => $v) {
                                  if( !alreadyTest($v,$val->fk_cbt_student) ) {
                                    $btn_show = false;
                                  }
                                  print '<li>'.getCBTName($v).' '.(alreadyTest($v,$val->fk_cbt_student)?'<span class="badge bg-success"><i class="fas fa-check"></i></span>':'<span class="badge bg-danger"><i class="fas fa-times-circle"></i></span>').'</li>';
                                }
                                print '</ul>';
                              @endphp
                            </td>
                            <td>
                              {!! alreadyGeneratedCert($cert->id, $val->id)?'<span class="badge bg-success">Yes</span>':'<span class="badge bg-danger">No</span>' !!}
                            </td>
                            <td>
                                @role('admin')
                                @if($btn_show && !alreadyGeneratedCert($cert->id, $val->id) )
                                <a href="{{ route('cert.generate',[$cert->id, $val->id]) }}" class="btn btn-primary btn-sm btn-equal">
                                  <i class="fas fa-file-pdf"></i> Generate Certificate
                                </a>
                                @endif

                                @if( alreadyGeneratedCert($cert->id, $val->id) )
                                <a href="{{ pathDownloadCert($cert->id, $val->id) }}" target="_blank" class="btn btn-success btn-sm btn-equal">
                                  <i class="fas fa-download"></i> Download Certificate
                                </a>
                                @endif
                                @endrole
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