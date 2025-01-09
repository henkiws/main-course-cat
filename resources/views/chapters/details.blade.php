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
            <li class="breadcrumb-item"><a href="{{ route('modules.index') }}">Module</a></li>
            <li class="breadcrumb-item"><a href="{{ route('chapters.show',[$chapter->fk_module]) }}">Chapter</a></li>
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
              <h3 class="card-title">Chapter: <strong>{{ $chapter->name??'' }}</strong></h3>

              <div class="card-tools">
                  <a href="{{ route('chapters.show',[$chapter->fk_module]) }}" class="btn btn-secondary btn-sm mr-2">
                      <i class="fas fa-arrow-left"></i> Daftar Chapter
                  </a>
                  @if( request()->get('page') > 1 )
                    <a href="{{ request()->get('page')>0? '?page='.(request()->get('page')-1) : '#' }}" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                  @else
                    <button href="{{ request()->get('page')>0? '?page='.(request()->get('page')-1) : '#' }}" class="btn btn-secondary btn-sm mr-2" disabled>
                      <i class="fas fa-arrow-left"></i>
                    </button>
                  @endif
                  @if( $chapter_video_count == request()->get('page') )
                    <button href="{{ !empty(request()->get('page')) ? (request()->get('page')>1 ? '?page='.(request()->get('page')+1) : '?page=2') : '?page=2'  }}" class="btn btn-secondary btn-sm" disabled>
                        <i class="fas fa-arrow-right"></i>
                    </button> 
                  @else
                    <a href="{{ !empty(request()->get('page')) ? (request()->get('page')>1 ? '?page='.(request()->get('page')+1) : '?page=2') : '?page=2'  }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-right"></i>
                    </a> 
                  @endif          
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              @forelse( $chapter_videos as $key => $val )
              <h3>Video</h3>
              <div class="embed-responsive embed-responsive-16by9 mb-4">
                  <iframe class="embed-responsive-item" style="width:100%;height:650px;" src="https://www.youtube.com/embed/{{ getYouTubeID($val->link) }}" allowfullscreen></iframe>
              </div>
              <h3>Title</h3>
              <p>{{ $val->title }}</p>
              <h3>Description</h3>
              <p>{{ $val->description }}</p>
              @empty
              <p class="text-center">No Data</p>
              @endforelse
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