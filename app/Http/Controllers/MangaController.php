<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use App\Manga;

class MangaController extends Controller {
    public function index() {
        $key = "data-manga";

        // Get Cache if key exist in redis database

        try {
            // getCache($key);
            $data = Manga::select('*')
                            ->wheres('id', '=', '230')
                            ->gets();

            return response()->json($data);
            // setCache($key, $data);

        } catch (Throwable $e) {
            return 'error';
        }

        // Set Cache if value of data in Key equals nil in redis database
        // deleteCache($key);

    }

}
