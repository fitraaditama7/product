<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use GuzzleHttp\Exeption\GuzzleException;
use GuzzleHttp\Client;
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

            $myData = [];
            foreach ($data as $keys => $values) {
                $myData[$keys] = $values->id;
            }

            $client = new Client();
            $result = $client->request('POST', 'localhost:8001/stok', [
                'form_params' => [
                    'id' => $myData
                ]
            ])->getBody()->getContents();

            $result = json_decode($result, true);
            $output = [];
            foreach ($data as $key => $datas) {
                foreach ($result['data'] as $key => $stok) {
                    if ($stok['id_product'] == $datas['id']) {
                        $datas['qty'] = $stok['qty'];
                        array_push($output, $datas);
                    }
                }
                if ($datas['qty'] == null) {
                    $datas['qty'] = 0;
                    array_push($output, $datas);
                }
            }
            // return $output;


            // if ($data == null) {
            //     return notFound();
            // } else {

            return responses($output, null);
            // }
        } catch (QueryException $th) {
            return $th;
        }
    }


}
