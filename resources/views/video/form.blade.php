@extends('layouts.main')

@section('content')
 <!--begin::App Content Header-->
 <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Form</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('modules.index') }}">Module</a></li>
            <li class="breadcrumb-item"><a href="{{ route('chapters.show',[$chapter->fk_module]) }}">Chapter</a></li>
            <li class="breadcrumb-item"><a href="{{ route('videos.index',['fk_chapter='.$chapter->id]) }}">Video</a></li>
            <li class="breadcrumb-item active" aria-current="page">Form</li>
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
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Form Video. Chapter: <strong>{{ $chapter->name }}</strong></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ isset($video->id) ? route('videos.update',[$video->id]) : route('videos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($video->id))
                    @method('PUT')
                    @endif
                  <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif

                    <input type="hidden" name="fk_chapter" value="{{ $chapter->id }}">
                    
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" required id="title" name="title" placeholder="Enter title" value="{{ isset($video->id) ? $video->title : old('title')  }}">
                    </div>
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" id="description" required name="description">{{ isset($video->id) ? $video->description : old('description')  }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="link">Link Youtube</label>
                      <input type="text" class="form-control" required id="link" name="link" placeholder="Enter link" value="{{ isset($video->id) ? $video->link : old('link')  }}">
                    </div>
                    <div class="form-group">
                      <label for="filepath">Upload File</label>
                      <input type="file" class="form-control" id="filepath" name="filepath">
                    </div>
                    <div class="form-group">
                      <label for="date_class">Date</label>
                      <input type="date" class="form-control" required id="date_class" name="date_class" placeholder="Enter date_class" value="{{ isset($video->id) ? \Carbon\Carbon::parse($video->date_class)->format('Y-m-d') : old('date_class')  }}">
                    </div>
                    <div class="form-group">
                      <label for="tutor">Tutor</label>
                      <input type="text" class="form-control" required id="tutor" name="tutor" placeholder="Enter tutor" value="{{ isset($video->id) ? $video->tutor : old('tutor')  }}">
                    </div>
                    <div class="form-group">
                      <label for="position">Position</label>
                      <input type="number" class="form-control" required id="position" name="position" placeholder="Enter position" value="{{ isset($video->id) ? $video->position : old('position')  }}">
                    </div>

                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection