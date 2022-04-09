<?php


namespace App\Controllers;

use App\Libraries\Controller;
//session_start();

class User extends Controller
{
    public function index()
    {
       // $this->view('login/login');
         $this->view('signin');
        
    }
    
    public function login()
    {
        $this->view('login');
    }

    public function signup(){
        // $postdata=$_POST ?? array();
    
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
            $users=$this->model('Users');
            $users->username=$_POST['name'];
            $users->email=$_POST['email'];
            $users->password=$_POST['password'];
            $users->role="Customer";
            $users->status="Restricted";
            $users->save();
        }
        
        $this->view('login');
        
    }
    public function login_data(){
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        if(isset($_POST['email']) && isset($_POST['password'])){
            $email=$_POST['email'];
            $password=$_POST['password'];
            $data = $this->model('Users')::find(array('email'=>$email , 'password'=>$password));
          
            if (!isset($_SESSION['userdata']))
            {
                $userdata=array('name' => $data->username, 'email' => $data->email, 'id' => $data->id);
                $_SESSION['userdata']=$userdata;
 
                // echo "<pre>";
                // print_r($_SESSION['userdata']);
                // echo "</pre>";
            }
            
       
            if($data->status=="Approved" && $data->role=="Admin"){
               // $this->view('/admin/index');
               header("Location: /Admin/index");

            }elseif($data->status=="Approved" && $data->role=="Customer"){
                $this->view("home");
            }else{
                $this->view('signin');

            }
        }


    }

    public function access(){
        
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $id=$_POST['userid'];
        $status=$_POST['status'];
        $data=$this->model('Users')::find(array('userid'=>$id));
        
        if($data->status=="Approved"){
            $data->status="Restricted";
            $data->save();
        }else{
            $data->status="Approved";
            $data->save();
        }
        $this->view('dashboard');
    }
    public function home(){
        $this->view('home');
    }

    public function blog(){
        echo "<pre>";
         print_r($_POST);
         echo "</pre>";

         if (isset($_POST['name']) && isset($_POST['title'])){
            $posts=$this->model('Posts');
            //$posts->id=$_POST['id'];
            $posts->username=$_POST['name'];
            $posts->title=$_POST['title'];
            $posts->content=$_POST['content'];
            $posts->save();
        }
        $this->view('myblogs');
        
    }

    public function myblogs(){
        $this->view('myblogs');
    }
    
    public function dashboard(){
        $this->view('dashboard');
    }
    public function edit(){

        // echo "<pre>";
        //  print_r($_POST);
        //  echo "</pre>";
         $id=$_POST['id'];
        $data=$this->model('Posts')::find_by_id($id);
        print_r($data);
        $this->view('updateblog', $data);

    }


      
      public function editblog(){
        
        echo "<pre>";
         print_r($_POST);
         echo "</pre>";
         $id=$_POST['id'];
         if (isset($_POST['name']) && isset($_POST['id']) && isset($_POST['title'])){
            $posts=$this->model('Posts')::find_by_id($id);
            
           // $posts->id=$_POST['id'];
            $posts->username=$_POST['name'];
            $posts->title=$_POST['title'];
            $posts->content=$_POST['content'];
            $posts->save();
    }
    $this->view('myblogs');
    }
}
