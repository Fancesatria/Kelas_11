<?php

namespace App\Controllers\Admin;

use App\Controllers\Basecontroller;
use App\Models\Kategori_M;
use App\Models\Menu_M;


class Menu extends BaseController
{
    public function index()
    {
        $pager = \Config\Services::pager();
        $model = new Menu_M();

        
        $data = [
            'judul' =>'Daftar Menu',
            'menu' => $model->paginate(3,'page'),
            'pager' => $model->pager
        ];

    
        return view("menu/select",$data);

    }


    public function read()
    {
        $pager = \Config\Services::pager();
        if (isset($_GET['idkategori'])) {
            $id = $_GET['idkategori'];

            $model = new Menu_M();
            $jumlah = $model->where('idkategori', $id) ->findAll();
            $count = count($jumlah);

            $tampil = 3;
            $mulai = 0;

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                $mulai = ($tampil * $page) - $tampil;
            }


            $menu = $model->where('idkategori', $id) ->findAll($tampil, $mulai);

            $data = [
                'judul' =>'Pencarian Menu',
                'menu' => $menu,
                'pager' => $pager,
                'tampil'=> $tampil,
                'total'=>$count
            ];
    
        
            return view("menu/cari",$data);
        }
    }


    public function create()
    {
        $model = new Kategori_M();

        $kategori = $model->findAll();
        $data = [
        'kategori' => $kategori ];
        return view("menu/insert",$data);
        
    }

    // FUNCTION UNTUK INSERT MENU
    public function insert()
    {
        $request = \Config\Services::request();
        $file = $request->getFile('gambar');
        $name = $file->getName();

        $data = [
            'idkategori' => $request ->getPost('idkategori'),
            'menu' => $request ->getPost('menu'),
            'gambar' => $name,
            'harga' => $request ->getPost('harga')

        ];


        $model = new Menu_M();
        
        
        if ($model -> insert($data)===false) {
            $error = $model->errors();
            session()->setFlashdata('info', $error);
            return redirect()->to(base_url("/admin/menu/create"));
        } else {
            $file->move('./upload');
            return redirect()->to(base_url("/admin/menu"));
        }
        

        // if ($model -> insert($_POST)===false) {
        //     $error = $model->errors();
        //     session()->setFlashdata('info', $error['kategori']);
        //     return redirect()->to(base_url("/admin/kategori/create"));
        // } else {
        //     
        // }
           
    }

    // FUNCTION UNTUK FORM UPDATE DATA
    public function find($id=null)
    {
        $model = new Menu_M();
        $menu = $model->find($id);

        $kategorimodel = new Kategori_M();
        $kategori = $kategorimodel->findAll();


        $data = [
            'judul' =>'Update Data',
            'menu' => $menu,
            'kategori' => $kategori
        ];

        return view("menu/update",$data);
    }

    // FUNCTION UNTUK UPDATE DATA
    public function update()
    {
        $id = $this-> request ->getPost('idmenu');
        $file = $this-> request ->getFile('gambar');
        $name = $file->getName();

        if (empty($name)) {
            $name = $this-> request ->getPost('gambar');;
        } else {
            $file->move('./upload');
        }
        

        $data = [
            'idkategori' => $this-> request ->getPost('idkategori'),
            'menu' => $this-> request ->getPost('menu'),
            'gambar' => $name,
            'harga' => $this-> request ->getPost('harga'),
        ];

        $model = new Menu_M();
        
        
        if ($model -> update($id,$data)===false) {
            $error = $model->errors();
            session()->setFlashdata('info', $error);
            return redirect()->to(base_url("/admin/menu/find/$id"));
        } else {
            $file->move('./upload');
            return redirect()->to(base_url("/admin/menu"));
        }
        
    }


    // FUNCTION UNTUK SELECT OPTION
    public function option()
    {
        $model = new Kategori_M();

        $kategori = $model->findAll();
        $data = [
        'kategori' => $kategori ];

        return view('template/option', $data);  
    }

    // FUNCTION UNTUK HAPUS DATA
    public function delete($id=null)
    {
        echo "<h1>proses menghapus data $id</h1>";

        $model = new Menu_M();
        $model-> delete($id);

        return redirect()->to(base_url("/admin/menu"));
    }
}

?>
