@extends('layouts.main')

@section('content')
 <!--begin::App Content Header-->
 <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Module</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('modules.index') }}">Modules</a></li>
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
                  <h3 class="card-title">Form Module</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ isset($module->id) ? route('modules.update',[$module->id]) : route('modules.store') }}" method="POST">
                    @csrf
                    @if(isset($module->id))
                    @method('PUT')
                    @endif
                  <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ isset($module->id) ? $module->name : old('name')  }}">
                    </div>
                    <div class="form-group">
                      <label for="name">Description</label>
                      <textarea class="form-control" id="description" name="description">{{ isset($module->id) ? $module->description : old('description')  }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="position">Position</label>
                      <input type="number" class="form-control" id="position" name="position" placeholder="Enter position" value="{{ isset($module->id) ? $module->position : old('position')  }}">
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