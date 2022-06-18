<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Log;

class SaleController extends Controller
{

    public function index(){
        $product = $this->geProduct()->get();
        return view('sale.index', compact('product'));
    }

    /**
     * > This function returns a new instance of the Product class
     * 
     * @return A new instance of the Product class.
     */
    public function geProduct(){
        return new Product();
    }

    public function saleRegister(Request $request){
        try {
            $this->data = $request->except('_token');
            $res = $this->geSale()->saleRegister(['total' => $this->data['totalPagar'], 'fecha_venta'=>date('Y-m-d')]);
            if($res > 0){
                foreach($this->data['venta'] as $key => $value){
                    $resdetail = $this->geSale()->registerDetail(['id_producto'=>$value['id'], 'id_venta' => $res, 'cantidad' => $value['cantidad'], 'valor_total'=>$value['total']]);
                    $updateProduct = $this->geProduct()->updateById(['id' => $value['id'], 'stock'=>$value['stock']]);
                }
                return response()->json(['data' => $this->data, 'msg' => 'Proceso exitoso'], 201);
            }else{
                return response()->json(['data' => $res, 'msg' => 'Ocurrió un error al intentar registrar el producto'], 500);
            }
        } catch (\Throwable $th) {
            Log::error('Error al intentar registrar venta. Revisar linea'.__LINE__.' del archivo '.__FILE__);
            Log::error('Detalle del error: '.$th);
            return response()->json(['data' => '', 'msg' => 'Ocurrió un error al intentar registrar venta'], 500);
        }
    }

    public function geSale(){
        return new Sale();
    }

}
