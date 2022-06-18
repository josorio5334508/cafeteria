@extends('layouts.app')

@section('title', 'Product')

@section('content')
            <!-- Modal -->
    <div class="modal fade" id="modalProduct" tabindex="-1" aria-labelledby="modalProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProductLabel">Crear producto</h5>
                <a class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <form action="" class="form-product-create" id="form-product-create" autocomplete="off">
                    @csrf
                    <div class="message"></div>
                    <input type="hidden" class="form-control" name="id">
                    <div class="mb-1">
                        <label for="">Nombre de producto <b class="text-danger">*</b></label>
                        <input type="text" class="form-control" name="nombre" title="Ingresar nombre del producto" data-obligatorio>
                    </div>
                    <div class="mb-1">
                        <label for="">Referencia <b class="text-danger">*</b></label>
                        <input type="text" class="form-control" name="referencia" title="Ingresar referencia" data-obligatorio>
                    </div>
                    <div class="mb-1">
                        <label for="">Precio <b class="text-danger">*</b></label>
                        <input type="number" class="form-control" name="precio" title="Digitar precio" data-obligatorio>
                    </div>
                    <div class="mb-1">
                        <label for="">Peso <b class="text-danger">*</b></label>
                        <input type="number" class="form-control" name="peso" title="Digitar peso " data-obligatorio>
                    </div>
                    <div class="mb-1">
                        <label for="">Categoría <b class="text-danger">*</b></label>
                        <input type="text" class="form-control" name="categoria" title="Ingresar categoria" data-obligatorio>
                    </div>
                    <div class="mb-3">
                        <label for="">Stock <b class="text-danger">*</b></label>
                        <input type="number" class="form-control" name="stock" title="Ingresar stock" data-obligatorio>
                    </div>
                    <div class="mb-2">
                        <label for="">Fecha creacion <b class="text-danger">*</b></label>
                        <input type="date" class="form-control" name="fecha_creacion" title="Seleccionar fecha" data-obligatorio>
                    </div>
                    <div class="mb-1 text-center">
                        <button class="btn btn-primary w-50">Guardar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
        </div>

        <div class="container">
            <div class="row mt-5">
                <div class="card border-0">
                    <div class="card-body">
                        <div>
                            <h5 class="card-title float-start">Productos</h5>
                            <a href="" class="btn btn-primary float-end btn-create" data-bs-toggle="modal" data-bs-target="#modalProduct">Crear producto</a>
                        </div>
                        <div class="table-responsive mt-5">
                            <div class="message-delete"></div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th>Referencia</th>
                                        <th>Precio</th>
                                        <th>Peso</th>
                                        <th>Categoría</th>
                                        <th>Stock</th>
                                        <th>Fecha creación</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="product-list">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            token = '{{ csrf_token() }}';
            url_create = '{{ route('product.create') }}';
            url_update = '{{ route('product.update') }}';
        </script>
        <script type="module" src="{{ asset('assets/js/product/index.js') }}"></script>
@endsection