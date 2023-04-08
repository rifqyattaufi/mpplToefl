<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $this->validate($request, [
            'nim_nik' => 'required|unique:users|min:10|max:16',
            'name' => 'required',
            'internal' => 'required',
            'password' => 'required|min:6'
        ]);

        $nimNik = $request->input('nim_nik');
        $name = $request->input('name');
        $internal = $request->input('internal');
        $password = Hash::make($request->input('password'));

        $user = User::create([
            'nim_nik' => $nimNik,
            'name' => $name,
            'internal' => $internal,
            'password' => $password
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function getAllUser()
    {
        $data = User::all();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    public function getUser($id)
    {
        $data = User::find($id);
        if ($data) {
            return response()->json([
                'message' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    }

    public function updateUser(Request $request, $id)
    {
        $data = User::find($id);
        if ($data) {

            if ($data->nim_nik != $request->input('nim_nik')) {
                $this->validate($request, [
                    'nim_nik' => 'required|unique:users|min:10|max:16',
                ]);
            }

            $this->validate($request, [
                'name' => 'required',
                'internal' => 'required',
            ]);

            $nimNik = $request->input('nim_nik');
            $name = $request->input('name');
            $internal = $request->input('internal');

            $data->nim_nik = $nimNik;
            $data->name = $name;
            $data->internal = $internal;
            $data->save();

            return response()->json([
                'message' => 'User updated',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    }

    public function deleteUser($id)
    {
        $data = User::find($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'message' => 'User deleted',
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    }
}
