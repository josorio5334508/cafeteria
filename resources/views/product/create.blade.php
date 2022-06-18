@extends('layouts.app')

@section('title', 'Product')

@section('content')

        <div class="container">
            <div class="row mt-3">
                <div class="card border-0">
                    <h5 class="card-title mt-2 text-center">Crear producto</h5>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <form action="" class="w-50 form-product-create" id="form-product-create">
                                @csrf
                                <a href="{{ route('product.list') }}">Lita de productos</a>
                                <div class="message"></div>
                                <input type="text" name="id">
                                <div class="mb-2">
                                    <label for="">Nombre de producto <b class="text-danger">*</b></label>
                                    <input type="text" class="form-control" name="nombre" title="Ingresar nombre del producto" data-obligatorio value="a">
                                </div>
                                <div class="mb-2">
                                    <label for="">Referencia <b class="text-danger">*</b></label>
                                    <input type="text" class="form-control" name="referencia" title="Ingresar referencia" data-obligatorio value="a">
                                </div>
                                <div class="mb-2">
                                    <label for="">Precio <b class="text-danger">*</b></label>
                                    <input type="number" class="form-control" name="precio" title="Digitar precio" data-obligatorio value="5">
                                </div>
                                <div class="mb-2">
                                    <label for="">Peso <b class="text-danger">*</b></label>
                                    <input type="number" class="form-control" name="peso" title="Digitar peso " data-obligatorio value="2">
                                </div>
                                <div class="mb-2">
                                    <label for="">Categoría <b class="text-danger">*</b></label>
                                    <input type="text" class="form-control" name="categoria" title="Ingresar categoria" data-obligatorio value="a">
                                </div>
                                <div class="mb-3">
                                    <label for="">Stock <b class="text-danger">*</b></label>
                                    <input type="number" class="form-control" name="stock" title="Ingresar stock" data-obligatorio value="1">
                                </div>
                                <div class="mb-3">
                                    <label for="">Fecha creacion <b class="text-danger">*</b></label>
                                    <input type="date" class="form-control" name="fecha_creacion" title="Seleccionar fecha" data-obligatorio value="2022-06-17">
                                </div>
                                <div class="mb-2 text-center">
                                    <button class="btn btn-primary w-50">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            token = '{{ csrf_token() }}';
            url_create = '{{ route('product.create') }}';
        </script>
        <script type="module" src="{{ asset('assets/js/product/index.js') }}"></script>
@endsection