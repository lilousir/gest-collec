<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemTypeModel extends Model
{
    protected $table            = 'type';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','slug','id_type_parent'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getTypeById($id) {
        return $this->find($id);
    }

    public function getAllTypes() {
        return $this->findAll();
    }

    public function deleteType($id) {
        return $this->delete($id);
    }
    public function updateType($id, $data) {
        if (isset($data['name'])) {
            $data['slug'] = $this->generateUniqueSlug($data['name'],$id);
        }
        if ($data['id_type_parent'] == 'none') {
            $data['id_type_parent'] = null;
        }
        return $this->update($id, $data);
    }

    public function getTypeBySlug($slug) {
        return $this->where('slug',$slug)->first();
    }
    public function insertType($item) {
        if(isset($item['id_type_parent']) && empty($item['id_type_parent'])) {
            unset($item['id_type_parent']);
        }
        if (isset($item['name'])) {
            $item['slug'] = $this->generateUniqueSlug($item['name']);
        }
        return $this->insert($item);
    }

    private function generateUniqueSlug($name)
    {
        $slug = generateSlug($name);
        $builder = $this->builder();
        $count = $builder->where('slug', $slug)->countAllResults();
        if ($count === 0) {
            return $slug;
        }
        $i = 1;
        while ($count > 0) {
            $newSlug = $slug . '-' . $i;
            $count = $builder->where('slug', $newSlug)->countAllResults();
            $i++;
        }
        return $newSlug;
    }

    public function getPaginated($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();
        // Recherche
        if ($searchValue != null) {
            $builder->like('name', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }

        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function getTotal()
    {
        $builder = $this->builder();
        return $builder->countAllResults();
    }

    public function getFiltered($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        return $builder->countAllResults();
    }
}