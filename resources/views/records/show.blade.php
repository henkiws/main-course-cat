@extends('layouts.main')

@section('content')
 <!--begin::App Content Header-->
 <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Show</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('records.index') }}">Record</a></li>
            <li class="breadcrumb-item active" aria-current="page">Show</li>
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
              <h3 class="card-title">Record: <strong>{{ $record->title??'' }}</strong></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <h3>Video</h3>
              <div class="embed-responsive embed-responsive-16by9 mb-4">
                  <iframe class="embed-responsive-item" style="width:100%;height:650px;" src="https://www.youtube.com/embed/{{ getYouTubeID($record->link) }}" allowfullscreen></iframe>
              </div>
              <h3>Title</h3>
              <p>{{ $record->title }}</p>
              <h3>Description</h3>
              <p>{{ $record->description }}</p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@push('css')
<style>
  .embed-responsive {
      position: relative;
      display: block;
      width: 100%;
      padding: 0;
      overflow: hidden;
  }
</style>
@endpush