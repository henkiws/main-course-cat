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
            <li class="breadcrumb-item"><a href="{{ route('files.index') }}">Files</a></li>
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
                  <h3 class="card-title">Form File</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ isset($file->id) ? route('files.update',[$file->id]) : route('files.store') }}" method="POST">
                    @csrf
                    @if(isset($file->id))
                    @method('PUT')
                    @endif
                  <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{ isset($file->id) ? $file->title : old('title')  }}">
                    </div>
                    <div class="form-group">
                      <label for="name">Description</label>
                      <textarea class="form-control" id="description" name="description">{{ isset($file->id) ? $file->description : old('description')  }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="date">Date</label>
                      <input type="date" class="form-control" id="date" name="date_class" placeholder="Enter date" value="{{ isset($file->id) ? \Carbon\Carbon::parse($file->date_class)->format('Y-m-d') : old('date_class')  }}">
                    </div>
                    <div class="form-group">
                      <label for="tutor">Tutor</label>
                      <input type="text" class="form-control" id="tutor" name="tutor" placeholder="Enter tutor" value="{{ isset($file->id) ? $file->tutor : old('tutor')  }}">
                    </div>
                    <div class="form-group">
                      <label for="file">Upload File</label>
                      <input type="file" class="form-control" id="file" name="file" placeholder="Enter file">
                    </div>
                    <div class="form-group">
                      <label for="position">Position</label>
                      <input type="number" class="form-control" id="position" name="position" placeholder="Enter position" value="{{ isset($file->id) ? $file->position : old('position')  }}">
                    </div>
                    <div class="form-group">
                      <label for="name">Group</label>
                      <select class="form-control" name="fk_group[]" multiple>
                          @foreach($opt_group as $key => $val)
                          <option value="{{ $key }}" 
                            @isset($file->id)
                              @php
                                foreach( $groups as $k => $v ) {
                                  if( $v->fk_group == $key ) {
                                    print 'selected';
                                  }
                                }
                              @endphp
                            @endisset
                          >{{ $val }}</option>
                          @endforeach
                      </select>
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