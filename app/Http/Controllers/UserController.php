<?php

namespace App\Http\Controllers;

use App\Http\Requests\userRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            // Retorna os dados paginado da tebala 'users'
            $data = User::all();

            return response()->json([
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $UserRequest
     * @return \Illuminate\Http\Response
     */
    public function store(userRequest $request)
    {
        $data = $request->all();

        $picture = $request->file('picture');
        try {

            // Criptografia da senha
            $data['password'] = Hash::make($data['password']);

            // Cria um usuario com os dados enviados
            $user = User::create($data);

            // Caso tenha enviado uma imagem salva os dados
            if ($picture) {
                $path = $picture->store('picture', 'public');
                $user->picture = $path;
                $user->save();
            }

            // Retorno para o cliente
            return response()->json([
                'data' => [
                    'mensagem' => 'Usuário cadastrado com sucesso.',
                    'request' => $user
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            // Retorna o usuario especifico
            return response()->json([
                'response' => User::findOrFail($id)
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\userRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('picture');
        $picture = $request->file('picture');
        try {
            $user = User::findOrFail($id);

            // Criptografia da senha
            if ($request->password) {
                $data['password'] = Hash::make($data['password']);
            }

            // Atualiza o usuario
            $user->update($data);

            // Caso tenha enviado uma foto atualiza e delata a anterior
            if ($picture) {
                if ($user->picture != '') {
                    Storage::delete($user->picture);
                }

                $path = $picture->store('picture', 'public');
                $user->picture = $path;
                $user->save();
            }

            // Retorna para o cliente
            return response()->json([
                'data' => [
                    'mensagem' => 'Usuário atualizado com sucesso.',
                    'request' => $user
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Delata a foto do cliente
            if ($user->picture != '') {
                Storage::delete($user->picture);
            }

            // Deleta os dados do abnco do cliente
            $user->delete();

            return response()->json([
                'data' => [
                    'mensagem' => "Usuário $id removido com sucesso.",
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }
}
