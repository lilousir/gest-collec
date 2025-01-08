<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Item extends ResourceController
{
   public function gettest(){
       $data = $this->request->getGet();
       $data_post =$this->request->getPost();
       return $this->response->setJSON([
           'response' =>'CouCou',
           'data' => $data_post,
       ]);
   } public function posttest(){
       $data = $this->request->getGet();
       $data_post =$this->request->getPost();
       return $this->response->setJSON([
           'response' =>'CouCou',
           'data' => $data,
           'data_post' => $data_post,
       ]);
   }
   public function getindex(){
       $data = $this->request->getGet();
       if(isset($data['id'])){
           $im = Model('ItemModel');
           $item = $im->getItem($data['id']);
            if($item) {
                return $this->response->setJSON([
                    'message' => 'success',
                    'item' => $item,
                ]);
            } else{
                return $this->response->setJSON([
                    'message' => 'error',
                ]);


            }
       }
       return $this->response->setJSON([
          'message' => 'error : pas d\ information' ,
       ]);
   }
   public function postindex()
   {
       $data = $this->request->getPost();
       if (isset($data['name']) && $data['name']) {
           $im = Model('ItemModel');
           $id_item = $im->insertItem($data);
           if ($id_item) {
               $item = $im->getItem($id_item);
               return $this->response->setJSON([
                   'message' => 'success',
                   'item' => $item,
               ]);

           } else {
               return $this->response->setJSON([
                   'message' => 'error objet non ajouter',
               ]);
           }
       }else {
           return $this->response->setJSON([
               'message' => 'error : pas d\ information',
           ]);

           }
       }
   }
