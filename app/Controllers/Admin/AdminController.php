<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuarioModel;

class AdminController extends BaseController
{
    public function __construct()
    {
        if (session()->get('rol') != "admin") {
            echo view('accesonoautorizado');
            exit;
        }
    }

    public function index()
    {
        $usuarioModel = new UsuarioModel();
        $usuarios = $usuarioModel->orderBy('id', 'DESC')->findAll();

        $data = [
            'usuarios'  => $usuarios
        ];

        return view('admin/dashboard', $data);
    }
}
