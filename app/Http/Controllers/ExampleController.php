<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $key = "data-all";

        if (app('redis')->exist($key) != null) {
            $data = app('redis')->get($key);

            return response()->json($data);
        }

        $data = "sabar";

        app('redis')->set($key, $data);

        return response()->json($data);
    }

    //
}
