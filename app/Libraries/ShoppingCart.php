<?php

namespace App\Libraries;

class ShoppingCart
{

    protected $session;

    public function __construct(){

        $this->session = session();

        if (!$this->session->has('cart')) {
            $this->session->set('cart', [
                'items' => [],
                'count' => 0,
                'total' => 0
            ]);
        }

    }
    public function addProduct(array $product){

        //Récupére le panier actuel depuis la session
        $cart = $this->session->get('cart') ?? ['items' => [], 'count' => 0, 'total' => 0];//Initialise un panier vide si absent


        //Vérifier si le produit existe déjas dans le panier
        $found = false;
        foreach ($cart['items'] as &$item) {
            if ($item['id'] == $product['id']) {
                //si le produit existe déja, augmenter la quantité
                $item['quantity'] += $product['quantity'];
                $found = true;
                break;
            }
        }
        //si le produit n'a pas été trouvé, l'ajouter comme nouvel élément
        if(!$found) {
            $cart['items'][] = $product;
        }
        //recalcul le total du panier
        $cart['total'] = $this->calculTotal($cart['items']);
        $cart['count'] = $this->calculCountItem($cart['items']);
        //mette a jour la sessionavec le nouveau panier
        $this->session->set('cart', $cart);
    }
    protected function calculTotal(array $items){
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'] ;
            //on suppose que chaque produit a 'price et qunatity

        }
        return $total;
    }
    protected function calculCountItem(array $items){
        $count = 0;
        foreach ($items as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }


}