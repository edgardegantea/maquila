<?php

namespace App\Controllers\Admin;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UsuarioModel;

class UsuarioController extends ResourceController
{


    private $usuario;    

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->session = \Config\Services::session();
        $this->usuario = new UsuarioModel();
    }


    public function index()
    {
        $usuarios = $this->usuario->orderBy('id', 'desc')->findAll(50);

        $data = [
            'usuarios'  => $usuarios
        ];
        // return view('admin/usuarios/index', $data);
        return view('admin/usuarios/index', $data);
    }

    
    public function show($id = null)
    {
        $usuario = $this->usuario->find($id);

        if ($usuario) {
            return view('admin/usuarios/show', compact('usuario'));
        } else {
            return redirect()->to('admin/usuarios');
        }
    }

    
    public function new()
    {
        return view('admin/usuarios/create');
    }

    
    public function create()
    {
        $usuario = new UsuarioModel();

        $data = [
            'rol'       => $this->request->getVar('rol'),
            'codigo'    => $this->request->getVar('codigo'),
            'nombre'    => $this->request->getVar('nombre'),
            'apaterno'  => $this->request->getVar('apaterno'),
            'amaterno'  => $this->request->getVar('amaterno'),
            'email'     => $this->request->getVar('email'),
            'password'  => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'foto'      => $this->request->getVar('foto'),
            'sexo'      => $this->request->getVar('sexo'),
            'bio'       => $this->request->getVar('bio')
        ];

        $rules = [
            'email'     => 'required|valid_email|is_unique[usuarios.email]'
        ];

        if ($this->validate($rules)) {
            $usuario->insert($data);
            return redirect()->to(site_url('/admin/usuarios'));
            session()->setFlashdata("success", "Usuario registrado con éxito");
        } else {
            $data['emailDuplicateError'] = lang('El correo electrónico ya se encuentra registrado.');
            return view('admin/usuarios/create', $data);
        }
    }

    
    public function edit($id = null)
    {
        $usuario = $this->usuario->find($id);
        if ($usuario) {
            return view('admin/usuarios/edit', compact('usuario'));
        } else {
            session()->setFlashdata('failed', 'Usuario no encontrado.');
            return redirect()->to('/admin/usuarios');
        }
    }

    
    public function update($id = null)
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($id);

        if (!$usuario) {
            return redirect()->to('/admin/usuarios')->with('error', 'Usuario no encontrado en la base de datos');
        }

        $data = [
            'id'        => $id,
            'rol'       => $this->request->getVar('rol'),
            'codigo'    => $this->request->getVar('codigo'),
            'nombre'    => $this->request->getVar('nombre'),
            'apaterno'  => $this->request->getVar('apaterno'),
            'amaterno'  => $this->request->getVar('amaterno'),
            'email'     => $this->request->getVar('email'),
            'foto'      => $this->request->getVar('foto'),
            'sexo'      => $this->request->getVar('sexo'),
            'bio'       => $this->request->getVar('bio')
        ];

        $usuarioModel->update($id, $data);
        return redirect()->to('/admin/usuarios')->with('success', 'Usuario actualizado exitosamente.');
    }

    
    public function delete($id = null)
    {
        $this->usuario->delete($id);

        session()->setFlashdata('success', 'Registro borrado de la base de datos');

        return redirect()->to(base_url('/admin/usuarios'));
    }
}
