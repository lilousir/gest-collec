<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table            = 'comment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'id_comment_parent','content','entity_id','entity_type'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;





    public function insertItemComment($data) {
        $data['entity_type'] = "item";
        return $this->insert($data);
    }
    public function insertCollectionComment($data) {
        $data['entity_type'] = "collection";
        return $this->insert($data);
    }

    public function getAllCommentsByItem($id_item) {
        $this->select("comment.id, comment.content, comment.updated_at as date, u.username, m.file_path as profile_file_path");
        $this->join('TableUser u', 'u.id = comment.id_user');
        $this->join("media m", "comment.id_user = m.entity_id and m.entity_type = 'user'", "left");
        $this->where("comment.entity_type", "item");
        $this->where("comment.entity_id", $id_item);
        return $this->findAll();
    }

    public function getAllCommentsByCollection($id_collection) {
        $this->select("comment.id, comment.content, comment.updated_at as date, u.username, m.file_path as profile_file_path");
        $this->join('TableUser u', 'u.id = comment.id_user');
        $this->join("media m", "comment.id_user = m.entity_id and m.entity_type = 'user'", "left");
        $this->where("comment.entity_type", "collection");
        $this->where("comment.entity_id", $id_collection);
        return $this->findAll();
    }
    public function getAllCommentsById() {
        $this->select("comment.id, comment.content, comment.updated_at as date, comment.entity_id,comment.id_user, comment.entity_type,comment.id_comment_parent as reponse, u.username, i.name");
        $this->join('TableUser u', 'u.id = comment.id_user');
        $this->join('item i', 'comment.entity_id = i.id');
        $this->where("comment.entity_type", "item");
        return $this->findAll();
    }
    public function getAllCommentsByUser($id) {
        $this->select("comment.id, comment.content, comment.updated_at as date, comment.entity_id, comment.entity_type, comment.id_comment_parent as reponse, i.name");
        $this->join('item i', 'comment.entity_id = i.id');
        $this->where("comment.entity_type", "item");
        $this->where("comment.id_user", $id);
        return $this->find();
    }
    public function getCommentById($id) {
        $this->select('comment.id, comment.id_user, comment.created_at, comment.id_comment_parent, comment.content , u.username, i.name as item_name, i.id as id_item');
        $this->join('TableUser u', 'u.id = comment.id_user');
        $this->join('item i', 'i.id = comment.entity_id');
        $this->where('comment.id', $id);
        return $this->first();
    }
    public function updateComment($data) {
        return $this->update($data['id'],$data);
    }

    public function deleteComment($id) {
        return $this->delete($id);
    }


}