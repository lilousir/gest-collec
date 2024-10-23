<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $require_auth = false;
    public function index($user = null): string
    {
        $im = model('ItemModel');

            $data = $this->request->getGet();
            // Définir le nombre d'éléments par page
            $perPage = 8;
            $genres = model('ItemGenreModel')->getAllGenres();
            $types = model('ItemTypeModel')->getAllTypes();
            $licenses = model('ItemLicenseModel')->getAllLicenses();
            $brands = model('ItemBrandModel')->getAllBrands();
            $allitems = $im->getAllItemsFiltered($data, 1, $perPage);
            // Récupérer le pager pour générer les liens de pagination
            $pager = $im->pager;
            return $this->view('accueil', [
                'items' => $allitems,
                'genres' => $genres,
                'types' => $types,
                'licenses' => $licenses,
                'brands' => $brands,
                'data' => $data,
                'pager' => $pager
            ]);




        }


    public function getforbidden() : string
    {
        return view('/templates/forbidden');
    }


}