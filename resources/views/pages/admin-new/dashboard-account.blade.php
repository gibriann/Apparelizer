@extends('pages.admin-new.layouts.admin')

@section('title','Dashboard')
    
@section ('content')
    <!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->

    <div class="text-dark mb-4">
        <div class="h3">Akun Saya</div>
    </div>
    <!-- Content Row -->

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard-account') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-2 align-self-center align-item-center">
                                <div class="media">
                                    <div class="px-2">
                                        @include('pages.partials.avatar-picker', ['user' => Auth::user(), 'inputId' => 'upload'])
                                    </div>
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label for="">Nama Lengkap</label>
                                    <input type="text" value="{{ Auth::user()->name }}" name="name" class="form-control @error('name') is-invalid @enderror" autofocus />
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control @error('email') is-invalid @enderror"/>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 text-right">
                            <button type="submit" class="py-2 px-4 btn text-center btn-success text-white"> Simpan </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
    <link href="{{ asset('style/avatar-picker.css') }}" rel="stylesheet" />
@endsection

@section('script')
    @include('pages.partials.avatar-picker-script')
@endsection