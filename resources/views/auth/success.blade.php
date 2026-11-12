@extends('layouts.success')

@section('title')
    Firmos - Registrasi Sukses!
@endsection

@section('content')
    <div class="page-content page-success">
        <div class="section-success" data-aos="zoom-in">
            <div class="container">
                <div class="row align-items-center row-login justify-content-center">
                    <div class="col-lg-6 text-center">
                        <img src="images/successlogo.png" alt="" class="mb-4" />
                        <h2>Registrasi berhasil!</h2>
                        <p>Terima kasih telah mendaftar.</p>
                        <div>
                            <a href="/dashboard.html" class="btn btn-success w-50 mt-4">Dasbor Saya</a>
                            <a href="/index.html" class="btn btn-signup w-50 mt-2">Mulai Belanja</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection