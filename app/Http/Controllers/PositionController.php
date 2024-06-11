<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function show(){
        $positions = $this->getAllPositions();
        if(!$positions){
            throw new HttpResponseException(response()->json(['success'=>false, 'message'=>'Positions not found'], 422));
        }
        return response()->json(['success'=>true, 'positions'=>Position::all()]);
    }
    private function getAllPositions(){
        return Position::all();
    }
}
