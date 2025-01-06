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
            <li class="breadcrumb-item"><a href="{{ route('cert.index') }}">Certificates</a></li>
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
                  <h3 class="card-title">Form Certificate</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ isset($cert->id) ? route('cert.update',[$cert->id]) : route('cert.store') }}" method="POST">
                    @csrf
                    @if(isset($cert->id))
                    @method('PUT')
                    @endif
                  <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{ isset($cert->id) ? $cert->title : old('title')  }}">
                    </div>
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ isset($cert->id) ? $cert->name : old('name')  }}">
                    </div>
                    <div class="form-group">
                      <label for="batch">Batch</label>
                      <input type="text" class="form-control" id="batch" name="batch" placeholder="Enter batch" value="{{ isset($cert->id) ? $cert->batch : old('batch')  }}">
                    </div>
                    <div class="form-group">
                      <label for="name">CBT</label>
                      <select class="form-control" name="details[]" multiple>
                          @foreach($opt_cbt_test as $key => $val)
                          <option value="{{ $key }}" 
                            @isset($cert->id)
                              @php
                                $toArray = json_decode($cert->details);
                                foreach( $toArray as $k => $v ) {
                                  if( $v == $key ) {
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