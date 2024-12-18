<?php

namespace Code\Http\Controllers\Tienda;

use Illuminate\Http\Request;
use Illuminate\Console\Events\ScheduledTaskFinished;
use Code\Http\Requests\Tienda\TiendaGiftcardRequest;
use Code\Models\Tienda\Tienda_Giftcard;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Code\Http\Controllers\Controller;
use Code\Models\Notificaciones;

class TiendaGiftcardController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $giftcards=DB::table('tienda_giftcard as gift')
            ->select('*')
            ->paginate(6);
            return view('admin.tienda.giftcard.index',["giftcards"=>$giftcards]);
        }
    }

    public function create()
    {
        return view('admin.tienda.giftcard.create');
    }

    public function store(TiendaGiftcardRequest $request)
    {
        $giftcard=new Tienda_Giftcard;
        $giftcard->codigo=$request->get('codigo');
        $giftcard->saldo=$request->get('valor');
        $giftcard->valor=$request->get('valor');
        $giftcard->nota=$request->get('nota');
        $giftcard->usado=1;
        $giftcard->estado=1;
        $giftcard->save();
        Notificaciones::create([
            'titulo' => 'Giftcard',
            'descripcion' => 'Nueva giftcard registrada.',
            'icono' => 'fa-duotone fa-gift-card',
            'color' => 'text-success',
            'url' => 'admin/tienda/giftcard',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/tienda/giftcard');
    }

    public function show($id)
    {
        return view('admin.tienda.giftcard.show',["giftcard"=> Tienda_Giftcard::findOrFail($id)]);
    }

    public function edit($id)
    {
        $giftcard = DB::table('tienda_giftcard as gift')
        ->select('*')
        ->where('gift.id', $id)
        ->first();
        return view('admin.tienda.giftcard.edit',["giftcard"=>$giftcard]);
    }

    public function update(TiendaGiftcardRequest $request,$id)
    {
        $giftcard=Tienda_Giftcard::findOrFail($id);
        if ($giftcard->usado) {
            $giftcard->codigo=$request->get('codigo');
            $giftcard->saldo=$request->get('valor');
            $giftcard->valor=$request->get('valor');
            $giftcard->nota=$request->get('nota');
            $giftcard->update();
            Notificaciones::create([
                'titulo' => 'Giftcard',
                'descripcion' => 'Giftcard editada.',
                'icono' => 'fa-duotone fa-gift-card',
                'color' => 'text-info',
                'url' => 'admin/tienda/giftcard',
                'visto' => 0,
                'toast' => 1,
            ]);
            return Redirect::to('admin/tienda/giftcard');        
        }
        else{
            return Redirect::to('admin/tienda/giftcard');
        }
    }

    public function destroy($id)
    {
        $giftcard=Tienda_Giftcard::findOrFail($id);
        $giftcard->estado=0;
        $giftcard->update();
        Notificaciones::create([
            'titulo' => 'Giftcard',
            'descripcion' => 'Giftcard eliminada.',
            'icono' => 'fa-duotone fa-gift-card',
            'color' => 'text-danger',
            'url' => 'admin/tienda/giftcard',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
