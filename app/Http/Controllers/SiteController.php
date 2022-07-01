<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardResource;
use App\Models\Card;
use App\Models\CardMovement;
use App\Models\Course;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $cards = Card::all();
        $cards = CardResource::collection($cards);
        return view('welcome')->with(['courses' => $courses, 'cards' => $cards->toJson(), 'count' => $cards->count()]);
    }

    public function show()
    {
        return CardResource::collection(Card::all());
    }

    public function cardUpdateNext(Request $request)
    {
        $card = $request->input('payload')['atual_card'];

        $card = Card::query()->where('id_card', '=', $card)->first();
        $card_id = $card->id_card;

        if($card->id_status === 2){
            if(!empty($card->card_teacher()->distinct()->get())){
                $card->where('id', '=', $card_id)->update(['id_status' => 3]);
                CardMovement::query()->create([
                    'id_card' => $card_id,
                    'id_status' => $card->id_status,
                    'dt_registro' => now()
                ]);
            }else{
                $card->where('id', '=', $card_id)->update(['id_status' => 4]);
                CardMovement::query()->create([
                    'id_card' => $card_id,
                    'id_status' => $card->id_status,
                    'dt_registro' => now()
                ]);
            }
        }

        if($card->id_status === 3){
            $now = Carbon::now();
            $dt_registro = Carbon::make($card['dt_registro']);

            if($now->diffInMinutes($dt_registro) < 1){
                return response()->json("Espere mais de um minuto para alterar esse card", 418);
            }else{
                $card->where('id', '=', $card_id)->update(['id_status' => 5]);
                CardMovement::query()->create([
                    'id_card' => $card_id,
                    'id_status' => $card->id_status,
                    'dt_registro' => now()
                ]);
            }
        }
        return \response()->json('', 200);
    }

    public function cardUpdatePrevious(Request $request){

    }
}
