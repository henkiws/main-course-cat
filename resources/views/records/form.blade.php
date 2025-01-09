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
            <li class="breadcrumb-item"><a href="{{ route('records.index') }}">Record</a></li>
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
                  <h3 class="card-title">Form Record</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ isset($record->id) ? route('records.update',[$record->id]) : route('records.store') }}" method="POST">
                    @csrf
                    @if(isset($record->id))
                    @method('PUT')
                    @endif
                  <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{ isset($record->id) ? $record->title : old('title')  }}">
                    </div>
                    <div class="form-group">
                      <label for="name">Description</label>
                      <textarea class="form-control" id="description" name="description">{{ isset($record->id) ? $record->description : old('description')  }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="date">Date</label>
                      <input type="date" class="form-control" id="date" name="date_class" placeholder="Enter date" value="{{ isset($record->id) ? \Carbon\Carbon::parse($record->date_class)->format('Y-m-d') : old('date_class')  }}">
                    </div>
                    <div class="form-group">
                      <label for="tutor">Tutor</label>
                      <input type="text" class="form-control" id="tutor" name="tutor" placeholder="Enter tutor" value="{{ isset($record->id) ? $record->tutor : old('tutor')  }}">
                    </div>
                    <div class="form-group">
                      <label for="link">Link Youtube</label>
                      <input type="text" class="form-control" id="link" name="link" placeholder="Enter link" value="{{ isset($record->id) ? $record->link : old('link')  }}">
                    </div>
                    <div class="form-group">
                      <label for="position">Position</label>
                      <input type="number" class="form-control" id="position" name="position" placeholder="Enter position" value="{{ isset($record->id) ? $record->position : old('position')  }}">
                    </div>
                    <div class="form-group">
                      <label for="name">Group</label>
                      <select class="form-control" name="fk_group[]" multiple required>
                          @foreach($opt_group as $key => $val)
                          <option value="{{ $key }}" 
                            @isset($record->id)
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