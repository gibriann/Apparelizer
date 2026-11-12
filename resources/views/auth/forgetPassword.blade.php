@extends('layouts.auth')

@section('title')
    Lupa Password
@endsection
@section('content')
<div class="page-content page-auth">
    <div class="section-store-auth" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center row-login">
                <div class="col-lg-6 text-center">
                    <img src="/images/login-placeholder.png" class="w-50 my-4 mb-lg-none" alt="" />
                </div>
                <div class="col-lg-4">
                    {{config('app.name')}}
                    <h2>Lupa password?</h2>
                    <form action="{{ route('forget.password.post') }}" method="POST" class="mt-3">
                        @csrf
                        <div class="form-group">
                            <label for="">Masukan alamat email anda. Kami akan mengirimkan email untuk mengubah password Anda.</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukan Email" />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success btn-block mt-2">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
