<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommentModel;


class Comment extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['collaborateur','utilisateur', 'administrateur'];

    public function getindex($id=null){
        if ($id) {
            return $this->view('/admin/comment-update', ['comment' => Model('CommentModel')->getCommentById($id)],true);
        }


        }


    public function postupdate() {
        $data = $this->request->getPost();
        if (model("CommentModel")->updateComment($data)) {
            $this->success("Commentaire modifié");
        } else {
            $this->error("Une erreur est survenue");
        }
        $this->redirect('/admin/item/comment');
    }
    public function getdelete($id) {

        if (model("CommentModel")->deleteComment($id)) {
            $this->success("Commentaire supprimer");
        } else {
            $this->error("Une erreur est survenue");
        }
        $this->redirect('/admin/item/comment');
    }
 }