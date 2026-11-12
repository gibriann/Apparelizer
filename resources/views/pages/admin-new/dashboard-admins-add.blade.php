@extends('pages.admin-new.layouts.admin')

@section('title','Dashboard')
    
@section ('content')
    <!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->

    <div class="text-dark mb-4">
        <div class="h3">Tambah Admin</div>
    </div>
    <!-- Content Row -->

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard-admin-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" autofocus />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" autofocus />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-block text-white">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.ckeditor.com/4.25.2-lts/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace("editor");
</script>

<script>
    const input = document.getElementById("upload");
    const text = document.getElementById("text");
    const btn = document.getElementById("upload-btn");

    input.addEventListener("change", () => {
        const path = input.value.split("\\");
        const filename = path[path.length - 1];

        text.innerText = filename ? filename : "Pilih foto";

        if (filename) btn.classList.add("chosen");
        else btn.classList.add("chosen");
    });
</script>
@endsection