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
            <li class="breadcrumb-item"><a href="{{ route('chapters.show',[isset($chapter->fk_module) ? $chapter->fk_module : $fk_module]) }}">Chapter</a></li>
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
                  <h3 class="card-title">Form Chapter Module: {{ isset($chapter->data_module->name) ? $chapter->data_module->name : $module->name }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ isset($chapter->id) ? route('chapters.update',[$chapter->id]) : route('chapters.store') }}" method="POST">
                    @csrf
                    @if(isset($chapter->id))
                    @method('PUT')
                    @endif
                  <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif

                    <input type="hidden" name="fk_module" value="{{ isset($chapter->id) ? $chapter->fk_module : $module->id }}">
                    
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ isset($chapter->id) ? $chapter->name : old('name')  }}">
                    </div>
                    <div class="form-group">
                      <label for="name">Description</label>
                      <textarea class="form-control" id="description" name="description">{{ isset($chapter->id) ? $chapter->description : old('description')  }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="position">Position</label>
                      <input type="number" class="form-control" id="position" name="position" placeholder="Enter position" value="{{ isset($chapter->id) ? $chapter->position : old('position')  }}">
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