<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Billet;

class BilletController extends Controller
{
    public function getAll(Request $request) {
        $array = ['error' => ''];

        $property = $request->input('property');
        if($property) {

            $billets = Billet::where('id_unit', $property)->get();

            foreach($billets as $billetKey => $billetValue) {
                $billets[$billetKey]['fileurl'] = asset('storage/'.$billetValue['fileurl']);
            }

        } else {
            $array['error'] = 'A propriedade é obrigatória.';
        }

        return $array;
    }
}
