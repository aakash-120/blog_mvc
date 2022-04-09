<?php

namespace App\Controllers;

use App\Libraries\Controller;

class Admin extends Controller
{
    public function index()
    {
        $this->view('/Admin/index');
    }

    public function access()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $id = $_POST['userid'];
        $status = $_POST['status'];
        $data = $this->model('Users')::find(array('userid' => $id));

        if ($data->status == "Approved") {
            $data->status = "Restricted";
            $data->save();
        } else {
            $data->status = "Approved";
            $data->save();
        }
        $this->view('/Admin/index');
    }

    public function blogs()
    {
        $this->view('/Admin/blogs');
    }

    public function edit()
    {

        // echo "<pre>";
        //  print_r($_POST);
        //  echo "</pre>";
        $id = $_POST['id'];
        $data = $this->model('Posts')::find_by_id($id);
        // print_r($data);
        $this->view('/Admin/updateblog', $data);
    }

    public function delete()
    {

        $id = $_POST['id'];
        $data = $this->model('Posts')::find_by_id($id)->delete();
        $this->view('/Admin/blogs');
    }

    public function editblog()
    {

        // echo "<pre>";
        //  print_r($_POST);
        //  echo "</pre>";
        $id = $_POST['id'];
        if (isset($_POST['name']) && isset($_POST['id']) && isset($_POST['title'])) {
            $posts = $this->model('Posts')::find_by_id($id);

            // $posts->id=$_POST['id'];
            $posts->username = $_POST['name'];
            $posts->title = $_POST['title'];
            $posts->content = $_POST['content'];
            $posts->save();
        }
        $this->view('/Admin/blogs');
    }

    public function signout()
    {
        
        print_r($_SESSION['userdata']);
       session_unset($_SESSION['userdata']);
       header("Location: /User/login");
        
       
    }
   
}
