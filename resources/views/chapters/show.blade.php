@extends('layouts.main')

@section('content')
 <!--begin::App Content Header-->
 <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Chapter</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('modules.index') }}">Module</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chapter</li>
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
              <h3 class="card-title">Module: <strong>{{ $module->name??'' }}</strong></h3>

              <div class="card-tools">
                <a href="{{ route('chapters.create',['module='.$module->id]) }}" class="btn btn-sm btn-primary">Add New Chapter</a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th class="text-center">Position</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $val)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $val->name }}</td>
                            <td>{{ $val->description }}</td>
                            <td class="text-center">{{ $val->position }}</td>
                            <td>
                                <a href="{{ route('videos.index',['fk_chapter='.$val->id]) }}" class="btn btn-primary btn-sm btn-equal">
                                    <i class="fas fa-plus"></i> 
                                </a>
                                <a href="{{ route('chapters.details',[$val->id]) }}" class="btn btn-info btn-sm btn-equal">
                                    <i class="fas fa-eye"></i> 
                                </a>
                                <a href="{{ route('chapters.edit',[$val->id]) }}" class="btn btn-warning btn-sm btn-equal">
                                    <i class="fas fa-edit"></i> 
                                </a>
                                <a href="{{ route('chapters.destroy',[$val->id]) }}" class="btn btn-danger btn-sm btn-equal" onclick="event.preventDefault();document.getElementById('form{{ $val->id }}').submit()">
                                    <i class="fas fa-trash"></i> 
                                </a>
                                <form id="form{{ $val->id }}" action="{{ route('chapters.destroy',[$val->id]) }}" method="POST" class="d-none">
                                  @csrf
                                  @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>

            {{ $list->links() }}

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection