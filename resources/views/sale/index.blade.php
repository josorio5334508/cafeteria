@extends('layouts.app')

@section('title', 'Product')

@section('content')

        <div class="container">
            <div class="row mt-5">
                <div class="card border-0">
                    <div class="card-body row">
                        <div class="col-sm-12">
                            <h5 class="card-title float-start">Ventas</h5>
                            <!-- <a href="" class="btn btn-primary float-end btn-create" data-bs-toggle="modal" data-bs-target="#modalProduct">Crear producto</a> -->
                            <form action="">
                                @csrf
                            </form>
                        </div>
                        <div class="message mt-4"></div>
                        <div class="table-responsive mt-1 col-sm-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="detail-sale">
                                    @foreach($product as $key => $value)
                                        <tr>
                                            <td>{{ $value->nombre }}</td>
                                            <td>{{ $value->precio }}</td>
                                            <td class="stock-{{ $value->id }}">{{ $value->stock }}</td>
                                            <td>
                                                @if($value->stock <= 0)
                                                    <p class="text-danger">No es posible realizar la venta de este producto.</p>
                                                @else
                                                    <input type="number" class="form-control input-cantidad input-{{ $value->id }}" data-id="{{ $value->id }}" data-stock="{{ $value->stock }}" data-precio="{{ $value->precio }}" data-stock="{{ $value->stock }}">
                                                @endif
                                            </td>
                                            <td>
                                                <span class="total-{{ $value->id }}"></span>
                                            </td>
                                            <td class="text-center">
                                                @if($value->stock <= 0)
                                                    <button class="btn btn-success" disabled>Agregar</button>
                                                @else
                                                    <button class="btn btn-success btn-sm btn-agregar btn-agregar-{{ $value->id }}" data-id="{{ $value->id }}" data-stock="{{ $value->stock }}" data-precio="{{ $value->precio }}" data-stock="{{ $value->stock }}">Agregar</button>
                                                    <button class="btn btn-secondary btn-sm btn-cancelar btn-cancelar-{{ $value->id }}" data-id="{{ $value->id }}" data-stock="{{ $value->stock }}" data-precio="{{ $value->precio }}" data-stock="{{ $value->stock }}">Cancelar</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <h6>Total: $<span class="total-pagar"></span></h6>
                        </div>
                        <div class="text-end col-sm-6">
                            <button class="btn btn-primary btn-confirmar-venta" disabled>Confirmar venta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            token = '{{ csrf_token() }}';
            url_confirm_sale = '{{ route('sale.register') }}';
        </script>
        <script>

            document.addEventListener('DOMContentLoaded', () => {

                let venta = [],
                totalPagar = 0;
                document.addEventListener("keyup", (e) => {
                    if(e.target.matches('.input-cantidad')){
                        if(parseInt(e.target.value, 10) > parseInt(e.target.dataset.stock, 10)){
                            document.querySelector(`.total-${e.target.dataset.id}`).textContent = "La cantidad de productos supera el stock";
                            document.querySelector(`.btn-agregar-${e.target.dataset.id}`).setAttribute("disabled", "true")
                        }else{
                            document.querySelector(`.total-${e.target.dataset.id}`).textContent = (e.target.value * e.target.dataset.precio);
                            document.querySelector(`.btn-agregar-${e.target.dataset.id}`).removeAttribute("disabled")
                        }
                    }
                })

                document.addEventListener("click", (e) => {
                    if(e.target.matches('.btn-agregar')){
                        /* Pushing the name 'alondo' into the array 'venta' */
                        let cantidad = document.querySelector(`.input-${e.target.dataset.id}`).value;

                        totalPagar = 0;
                        cantidad = parseInt(cantidad, 10)
                        if(cantidad > 0){
                            venta.push({
                                id: e.target.dataset.id,
                                cantidad: cantidad,
                                stock: (parseInt(e.target.dataset.stock, 10) - cantidad),
                                total: (cantidad * e.target.dataset.precio)
                            })
                            e.target.disabled = true;

                            venta.map((ven) => {
                                totalPagar += ven.total
                            })
                            console.log(venta)
                            console.log(totalPagar)
                            document.querySelector(`.stock-${e.target.dataset.id}`).textContent = (parseInt(e.target.dataset.stock, 10) - cantidad)
                            document.querySelector(".total-pagar").textContent = totalPagar
                            document.querySelector(".btn-confirmar-venta").removeAttribute("disabled")

                        }
                    }

                    if(e.target.matches('.btn-cancelar')){
                        venta = venta.filter((item) => item.id !== e.target.dataset.id);

                        totalPagar = 0;
                        venta.map((ven) => {
                            totalPagar += ven.total
                        })
                        console.log(venta)
                        console.log(totalPagar)
                        document.querySelector(`.stock-${e.target.dataset.id}`).textContent = e.target.dataset.stock
                        document.querySelector(".total-pagar").textContent = totalPagar
                        document.querySelector(`.btn-agregar-${e.target.dataset.id}`).removeAttribute("disabled")
                        document.querySelector(`.input-${e.target.dataset.id}`).value = 0
                        document.querySelector(`.total-${e.target.dataset.id}`).innerHTML = ''
                        if(totalPagar <= 1){
                            document.querySelector(".btn-confirmar-venta").setAttribute("disabled", "true")
                        }
                    }

                    if(e.target.matches('.btn-confirmar-venta')){
                        console.log(totalPagar)
                        console.log(venta)
                        if(totalPagar > 0){
                            fetch(url_confirm_sale, {
                                method: 'POST',
                                headers: {'Content-Type': 'application/json; charset=utf-8'},
                                body: JSON.stringify({_token: token, totalPagar, venta})
                            })
                            .then(res => res.json())
                            .then(json => {
                                document.querySelector(".message").innerHTML = `<div class="alert alert-danger">${json.msg}</div>`;
                                setTimeout(() => { 
                                    document.querySelector(".message").innerHTML = ``; 
                                    window.location.reload();
                                }, 3000)
                            })
                            .catch(err => console.log(err))
                        }
                    }

                })

            })
        </script>

@endsection