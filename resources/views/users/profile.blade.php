@extends('layouts.main')

@section('content')
 <!--begin::App Content Header-->
 <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Profile</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
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
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ !empty(auth()->user()->avatar) ? asset(auth()->user()->avatar) : asset('data/nouser.png') }}" alt="User profile picture">
              </div>

              <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

              <p class="text-muted text-center">{{ implode(', ', auth()->user()->roles()->pluck('name')->toArray()) }}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Email</b> : {{ auth()->user()->email }}
                </li>
                <li class="list-group-item">
                  <b>Join Date</b> : {{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('d M Y') }}
                </li>
              </ul>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal" action="{{ route('profile.update',[auth()->user()->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                <input type="hidden" name="role" value="{{ $user->roles->pluck("name")->first() }}">
                <input type="hidden" name="fk_group" value="{{ $user->data_user_group->fk_group??0 }}">
                <div class="form-group row">
                  <label for="fullname" class="col-sm-2 col-form-label">Fullname</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="fullname" placeholder="Fullname" name="name" value="{{ auth()->user()->name }}">
                  </div>
                </div>
                <div class="form-group row mt-3">
                  <label for="password" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" >
                    <div class="text-muted small">Silahkan isi untuk mengubah password.</div>
                  </div>
                </div>
                <div class="form-group row mt-3">
                  <label for="avatar" class="col-sm-2 col-form-label">Avatar</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/png, image/gif, image/jpeg">
                    <div class="text-muted small">Silahkan pilih file untuk mengubah avatar.</div>
                  </div>
                </div>
                <div class="form-group row mt-3">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Submit</button>
                  </div>
                </div>
              </form>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
 
@endsection