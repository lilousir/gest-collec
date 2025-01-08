<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ShoppingCart;
use CodeIgniter\HTTP\ResponseInterface;

class Cart extends BaseController
{
    protected $require_auth = false;
    public function getindex()
    {
       return $this->view('/item/cart');
    }
    public function postaddproduct(){
        $data = $this->request->getPost();
        $cart = new ShoppingCart();
        $cart->addProduct($data);
        $this->success('produit ajouter');
        $this->redirect('/item');
        print_r($data);
    }
}
