<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class UserController extends BaseController
{

    public function login()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'username' => 'required|min_length[5]|max_length[50]',
                'password' => 'required|min_length[8]|max_length[255]|validateUser[username,password]',
            ];

            $errors = [
                'password' => [
                    'validateUser' => "Nombre de usuario o contraseña incorrecta",
                ],
            ];

            if (!$this->validate($rules, $errors)) {

                echo "Error";
                /*
                                return view('login', [
                                    "validation" => $this->validator,
                                ]);
                                */
            } else {
                $model = new UsuarioModel();

                $user = $model->where('username', $this->request->getVar('username'))->first();
                $this->setUserSession($user);

                if ($user['rol'] == "admin") {
                    return redirect()->to(base_url('admin'));
                }

                if ($user['rol'] == "encargado") {
                    return redirect()->to(base_url('encargado'));
                }

                if ($user['rol'] == "operario") {
                    return redirect()->to(base_url('operario'));
                }
            }
        }
        return view('login');
    }


    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'nombre' => $user['nombre'],
            'apellido_paterno' => $user['apellido_paterno'],
            'apellido_materno' => $user['apellido_materno'],
            'username' => $user['username'],
            'email' => $user['email'],
            'isLoggedIn' => true,
            'rol' => $user['rol']
        ];

        session()->set($data);
        return true;
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

}


