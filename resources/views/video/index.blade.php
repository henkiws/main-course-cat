@extends('layouts.main')

@section('content')
 <!--begin::App Content Header-->
 <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Video</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('modules.index') }}">Module</a></li>
            <li class="breadcrumb-item"><a href="{{ route('chapters.show',[$chapter->id]) }}">Chapter</a></li>
            <li class="breadcrumb-item active" aria-current="page">Video</li>
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
              <h3 class="card-title">Chapter: {{ $chapter->name }}</h3>

              <div class="card-tools">
                <a href="{{ route('videos.create',['fk_chapter='.$fk_chapter]) }}" class="btn btn-sm btn-primary">Add New Video Chapter</a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Link</th>
                    <th>Date</th>
                    <th>Tutor</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $val)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $val->title }}</td>
                            <td>{{ $val->description }}</td>
                            <td>{{ $val->link }}</td>
                            <td>{{ $val->date_class }}</td>
                            <td>{{ $val->tutor }}</td>
                            <td>
                                <a href="{{ route('videos.edit',[$val->id,'fk_chapter='.$fk_chapter]) }}" class="btn btn-warning btn-sm btn-equal">
                                    <i class="fas fa-edit"></i> 
                                </a>
                                <a href="{{ route('videos.destroy',[$val->id,'fk_chapter='.$fk_chapter]) }}" class="btn btn-danger btn-sm btn-equal" onclick="event.preventDefault();document.getElementById('form{{ $val->id }}').submit();">
                                    <i class="fas fa-trash"></i> 
                                </a>
                                <form id="form{{ $val->id }}" action="{{ route('videos.destroy',[$val->id,'fk_chapter='.$fk_chapter]) }}" method="POST" class="d-none">
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