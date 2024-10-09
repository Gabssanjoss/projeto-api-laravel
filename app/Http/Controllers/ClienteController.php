<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function listar()
    {
       $customers = Cliente:: all(); 
        return ApiResponse:: success('Lista de clientes', $customers);
    }

    public function listarPeloId(int $id)
    {
        $customers = Cliente::findOrFail($id); 
        return ApiResponse:: success('Lista de clientes', $customers);
    }

    public function salvar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|unique:clientes|max:200',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Erro de validação', $validator->errors());
        }

        $costumer = Cliente::create($request->all());
        return ApiResponse::success('Salvo com sucesso!', $costumer);

    }

    public function editar(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:200',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Erro de validação', $validator->errors());
        }

        $costumer = Cliente::findOrFail($id);
        $costumer->update($request->all());

        return ApiResponse::success('Salvo com sucesso!', $costumer);
    }

    public function deletar(int $id)
    {
        $customer = Cliente::findOrFail($id);
        $customer->delete();
        return ApiResponse::success('Cliente removido com sucesso!');
    }
}
