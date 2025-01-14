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
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
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
                  <h3 class="card-title">Form User</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ isset($user->id) ? route('users.update',[$user->id]) : route('users.store') }}" method="POST">
                    @csrf
                    @if(isset($user->id))
                    @method('PUT')
                    @endif
                  <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ isset($user->id) ? $user->name : old('name')  }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter name" value="{{ isset($user->id) ? $user->email : old('email')  }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="name">Role</label>
                        <select class="form-control" name="role" {{ isset($user->id) ? ($user->roles->pluck("name")->first() ? "disabled" : "") : '' }}>
                            @foreach($opt_role as $key => $val)
                            <option value="{{ $val }}" {{ isset($user->id) ? ($user->roles->pluck("name")->first() == $val ? "selected" : "") : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    @isset($user->id)
                    <input type="hidden" name="role" value="{{ $user->roles->pluck("name")->first() }}">
                    @endisset
                    <div class="form-group">
                        <label for="name">Group</label>
                        <select class="form-control" name="fk_group">
                            @foreach($opt_group as $key => $val)
                            <option value="{{ $key }}" {{ isset($user->id) ? ($user->data_user_group->fk_group == $key ? 'selected' : '') : '' }}>{{ $val }}</option>
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