<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller {
    public function index() {
        try {

            $data = Product::select([
                        'id',
                        'title',
                        'sku',
                        'jumlah_kemasan',
                        'viewer',
                    ])
                    ->get();
            return responses($data, null);

        } catch (QueryException $th) {
            return errorQuery($th->getMessage());
        }
    }

    public function getProductId(Request $request) {
        $id = unserialize($request->id);

        try {
            $data = Product::select([
                        'id',
                        'sku',
                        'title'
                    ])
                    ->whereIn('id', $id)
                    ->get();
            // if ($data == null) {
            //     return notFound();
            // } else {
                return responses($data, null);
            // }
        } catch (QueryException $th) {
            return errorQuery($th->getMessage());
        }
    }


}
