@extends('pages.admin-new.layouts.admin')

@section('title','Dashboard')
    
@section ('content')
    <!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->

    <div class="text-dark mb-4">
        <div class="h3">Laporan Penjualan Firmos</div>
        <p>Kepuasan pelanggan adalah kunci</p>
    </div>
    <!-- Content Row -->

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header border-0">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <div class="nav-link active border-0">Periode</div>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <form action="/dashboard/reports/periode" method="POST" target="_blank">
                                @csrf
                                <label class="col-form-label">Cetak Laporan Berdasarkan Periode</label>
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <select class="form-control @error('periode') is-invalid @enderror" id="periode" name="periode" value="{{ old('periode') }}">
                                            <option value="hari ini">Hari Ini</option>
                                            <option value="minggu ini">Minggu Ini</option>
                                            <option value="bulan ini">Bulan Ini</option>
                                            <option value="tahun ini">Tahun Ini</option>
                                        </select>
                                        @error('periode')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <button class="btn btn-secondary btn-icon-split mb-1" type="submit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-print"></i>
                                            </span>
                                            <span class="text">Cetak</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header border-0">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <div class="nav-link active border-0">Tanggal</div>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tanggal" role="tabpanel"  aria-labelledby="tanggal-tab">
                            <form action="/dashboard/reports/date" method="POST" target="_blank">
                                @csrf
                                <label class="col-form-label">Cetak Laporan Berdasarkan Tanggal</label>
                                <div class="form-row">
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control @error('tgl_awal') is-invalid @enderror" name="tgl_awal" placeholder="Tanggal Awal" value="{{old('tgl_awal')}}">
                                        @error('tgl_awal')
                                            <div class="invalid-feedback"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-1 mt-2">
                                        <div class="text-center">
                                            <i class="fa fa-minus"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control @error('tgl_akhir') is-invalid @enderror" name="tgl_akhir" placeholder="Tanggal Akhir"value="{{old('tgl_akhir')}}">
                                        @error('tgl_akhir')
                                            <div class="invalid-feedback"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-secondary btn-icon-split mb-1" target="blank" type="submit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-print"></i>
                                            </span>
                                            <span class="text">Cetak</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $('#card-list a').on('click', function (e) {
            e.preventDefault()
            $(this).tab('show')
        })
    </script>
    <script>
        $(function(){
            $("#upload_link").on('click', function(e){
                e.preventDefault();
                $("#upload:hidden").trigger('click');
            });
        });
    </script>

    <script type="text/javascript">
        $('#upload').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => { 
                $('#avatar').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
        });
    </script>
@endsection