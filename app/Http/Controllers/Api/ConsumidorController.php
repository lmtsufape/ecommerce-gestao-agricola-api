<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\Consumidor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ConsumidorController extends Controller
{
    public function index()
    {
        $consumidores = User::where("users.papel_type", "=", "Consumidor")->join("consumidors", "consumidors.id", "=", "users.papel_id")
            ->orderBy('name')
            ->get();
        if (!$consumidores) {
            return response()->json(['erro' => 'Nenhum consumidor cadastrado'], 200);
        }
        return response()->json(['usuários' => $consumidores], 200);
    }
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        $consumidor = new Consumidor();
        $consumidor->save();

        $consumidor = $consumidor->user()->create($request->except('passowrd'));
        if (!$consumidor) {
            return response()->json(['erro' => 'Não foi possível criar o usuário'], 400);
        }
        $consumidor->password = Hash::make($request->password);
        $consumidor->save();
        $consumidor->user;
        DB::commit();
        return response()->json(['usuário' => $consumidor], 201);
    }
    public function show($id)
    {
        $consumidor = Consumidor::find($id);
        $consumidor->user;
        if (!$consumidor) {
            return response()->json(['erro' => 'Usuário não encontrado'], 404);
        }
        return response()->json(['usuário' => $consumidor], 200);
    }
    public function update(StoreUserRequest $request)
    {
        DB::beginTransaction();

        $consumidor = Consumidor::find($request->consumidor);
        if (!$consumidor) {
            return response()->json(['erro' => 'Usuário não encontrado'], 404);
        }
        $consumidor->fill($request->all());
        $consumidor->save();
        $consumidor->user;
        DB::commit();
        return response()->json([$consumidor], 200);
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        $consumidor = Consumidor::find($id);
        $consumidor->delete();
        DB::commit();
        return response()->noContent();
    }
}
