<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuarioModel;

class RegistroController extends BaseController
{
    public function new()
    {
        return view('pages/registro');
    }


    public function create()
    {
        $usuarioModel = new UsuarioModel();

        $data = [
            'rol'               => 'admin',
            'nombre'            => $this->request->getPost('nombre'),
            'apellido_paterno'  => $this->request->getPost('apellido_paterno'),
            'apellido_materno'  => $this->request->getPost('apellido_materno'),
            'username'          => $this->request->getPost('username'),
            'email'             => $this->request->getPost('email'),
            'password'          => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'sexo'              => $this->request->getPost('sexo'),
            'fecha_nacimiento'  => $this->request->getPost('fecha_nacimiento'),
            'stado'             => 1
        ];

        $usuarioModel->insert($data);

        return redirect()->to('login');
    }
}
