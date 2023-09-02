@extends('layouts.template_index')

@section('header', 'Dashboard')

@section('css')
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>20</h3>
                        <p>Mobil</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cube"></i>
                    </div>

                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3></h3>
                        <p>Peminjaman</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cubes"></i>
                    </div>

                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3></h3>
                        <p>Pengembalian</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-id-card"></i>
                    </div>

                </div>
            </div>

        </div>




    </div>
@endsection

@section('js')
@endsection
