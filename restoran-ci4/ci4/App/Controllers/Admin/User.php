<?php

namespace App\Controllers\Admin;

use App\Controllers\Basecontroller;
use App\Models\Kategori_M;
use App\Models\User_M;

class User extends BaseController
{

    public function index()
    {
        $pager = \Config\Services::pager();
        $model = new User_M();
        
        
        $data = [
            'judul' =>'Data User',
            'user' => $model->paginate(3,'page'),
            'pager' => $model->pager
        ];

    
        return view("user/select",$data);
    }

    public function create()
    {
        $data = [
            'level' => ['Admin', 'Koki', 'Kasir', 'Gudang']
        ];

        return view("user/insert",$data);
    }

    public function insert()
    {

        if (isset($_POST['password'])) {
            $data = [
                'user' => $_POST['user'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT) ,
                'level' => $_POST['level'],
                'aktif' => 1
            ];


            $model = new User_M();

            if ($model -> insert($data)===false) {
                $error = $model->errors();
                session()->setFlashdata('info', $error);
                return redirect()->to(base_url("/admin/user/create"));
            } else {
                return redirect()->to(base_url("/admin/user"));
            }
        }

    }

    public function update($id=null, $isi=1)
    {
        $model = new User_M();
        if ($isi == 0) {
            $isi = 1;
        } else {
            $isi = 0;
        }

        $data = [
            'aktif' => $isi
        ];

        $model->update($id,$data);
        return redirect()->to(base_url("/admin/user"));
        
    }


    public function delete($id=null)
    {
        echo "<h1>proses menghapus data $id</h1>";

        $model = new User_M();
        $model-> delete($id);

        return redirect()->to(base_url("/admin/user"));
    }


    public function find($id=null)
    {
        $model = new User_M();
        $user = $model->find($id);

        $data = [
            'judul' =>'Update Data',
            'user' => $user,
            'level' => ['Admin', 'Koki', 'Kasir', 'Gudang']
        ];

        return view("user/update",$data);
    }


    public function ubah()
    {

        $id = $_POST['iduser'];

        $data = [
            'email' => $_POST['email'],
            'level' => $_POST['level']
        ];

        // echo $id;
        // echo $_POST['email'];
        // echo $_POST['level'];
        
        $model = new User_M();
        $model-> update($id, $data);
        return redirect()->to(base_url("/admin/user"));
    }




}

?>
