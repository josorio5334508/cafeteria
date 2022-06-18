<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Log;

class ProductController extends Controller
{
    /**
     * The function index() returns the view product.create
     * 
     * @param Request request This is the request object that contains all the information about the
     * request.
     * 
     * @return A view called product.create
     */
    public function index(){
        return view('product.list');
    }

    /**
     * > This function returns the view `product.list`
     * 
     * @param Request request The request object.
     * 
     * @return A view called product.list
     */
    public function list(){
        /* Getting all the products from the database. */
        $res = $this->geProduct()->get();
        return response()->json(['data' => $res, 'msg'=>'Ok'], 200);
    }

    public function create(Request $request){

        try {
            $this->data = $request->except('_token');
            $res = $this->geProduct()->create($this->data);
            if($res > 0){
                return response()->json(['data' => $this->data, 'msg' => 'Proceso exitoso'], 201);
            }else{
                return response()->json(['data' => $res, 'msg' => 'Ocurrió un error al intentar registrar el producto'], 500);
            }
        } catch (\Throwable $th) {
            Log::error('Error al intentar crear producto. Revisar linea'.__LINE__.' del archivo '.__FILE__);
            Log::error('Detalle del error: '.$th);
            return response()->json(['data' => '', 'msg' => 'Ocurrió un error al intentar crear el producto'], 500);
        }

    }


    public function update(Request $request){

        try {
            $this->data = $request->except('_token');
            $res = $this->geProduct()->updateById($this->data);
            if($res > 0){
                return response()->json(['data' => $this->data, 'msg' => 'Producto actualizado'], 200);
            }else{
                return response()->json(['data' => $res, 'msg' => 'Ocurrió un error al intentar actualizar el producto'], 500);
            }
        } catch (\Throwable $th) {
            Log::error('Error al intentar actualizar producto. Revisar linea'.__LINE__.' del archivo '.__FILE__);
            Log::error('Detalle del error: '.$th);
            return response()->json(['data' => '', 'msg' => 'Ocurrió un error al intentar actualizar el producto'], 500);
        }

    }

    public function delete($id){
        try {
            $res = $this->geProduct()->deleteById($id);
            if($res > 0){
                return response()->json(['data' => $id, 'msg' => 'Producto eliminado'], 200);
            }else{
                return response()->json(['data' => $res, 'msg' => 'Ocurrió un error al intentar eliminar el producto'], 500);
            }
        } catch (\Throwable $th) {
            Log::error('Error al intentar eliminar producto. Revisar linea'.__LINE__.' del archivo '.__FILE__);
            Log::error('Detalle del error: '.$th);
            return response()->json(['data' => '', 'msg' => 'Ocurrió un error al intentar eliminar el producto'], 500);
        }
    }


    /**
     * > This function returns a new instance of the Product class
     * 
     * @return A new instance of the Product class.
     */
    public function geProduct(){
        return new Product();
    }

}
