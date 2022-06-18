@extends('layouts.app')

@section('title', 'Product')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Producto con más stock</h5>
                    <p class="card-text"></p>
                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Producto más vendido</h5>
                    <p class="card-text"></p>
                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection