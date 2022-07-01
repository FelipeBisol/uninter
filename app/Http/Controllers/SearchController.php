<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardResource;
use App\Models\Card;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $exacts = $request->only('id_curso', 'num_aula');
        $ordenation = $request->only('ordemPor', 'ordenacao');
        $term = $request->only( 'professor');

        $query = Card::query();

        foreach ($exacts as $exact => $value){
            if($value){
                $query->where($exact, '=', $value);
            }
        }

        if(!empty($term['professor'])){
            $teacher = Teacher::query()->select('id_professor')
                ->where('nome', 'LIKE', "%{$term['professor']}%");

            if($ordenation['ordemPor'] === 'professor'){
                $teacher->orderBy('nome', $ordenation['ordenacao']);
            }else{
                $teacher->get();
            }

            if($teacher->isEmpty()){
                return response()->json('Não foi possível localizar o professor', 404);
            }

            $cards_id = [];

            foreach ($teacher as $item){
                $cards = $item->card;
                foreach ($cards as $card){
                    $cards_id[] = $card->id_card;
                }
            }
            $query->whereIn('id', $cards_id);
        }

        $result = $query->orderBy($ordenation['ordemPor'], $ordenation['ordenacao'])->get();

        return CardResource::collection($result);
    }
}
