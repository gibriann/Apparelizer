@extends('layouts.success')

@section('title')
    Firmos - Transaksi Sukses!
@endsection

@section('content')
    <div class="page-content page-success">
        <div class="section-success" data-aos="zoom-in">
            <div class="container">
                <div class="row align-items-center row-login justify-content-center">
                    <div class="col-lg-6 text-center">
                        <img src="images/successlogo.png" alt="" class="mb-4" />
                        <h2>Transaksi berhasil!</h2>
                        <p>
                            Silahkan tunggu konfirmasi email dari kami. <br />
                            Jika ada pertanyaan jangan sungkan untuk <i>chat</i> ke
                            <a href="https://www.whatsapp.com" class="text-success">Whatsapp</a>
                        </p>
                        <div>
                            <a href="{{ route('dashboard') }}" class="btn btn-success w-50 mt-4">Dasbor Saya</a>
                            <a href="{{ route('home') }}" class="btn btn-signup w-50 mt-2">Kembali Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection