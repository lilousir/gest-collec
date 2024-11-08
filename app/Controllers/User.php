<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['collaborateur','utilisateur', 'administrateur'];

    public function getindex()
    {
        if( isset($this->session->user)) {
            return $this->view("/login/user");
        } else {
            $this->redirect('/login');
        }
    }

    public function getsendmessage($username = null) {
        return $this->view("/message/sendmessage", ['username' => $username]);
    }

    public function postsendmessage() {
        $data = $this->request->getPost();
        $id_sender = $this->session->user->id;
        $id_receiver = Model('UserModel')->getIdUserByUsername($data['username_receiver']);
        if (!$id_receiver) {
            $this->error("Pas de destinataire");
            $this->redirect('/collection');
        }
        $data['id_receiver'] = $id_receiver;
        $data['id_sender'] = $id_sender;
        if (Model('MessageModel')->insertMessage($data)) {
            $this->success('Message envoyé à ' . $data['username_receiver']);
            $this->redirect('/collection');
        }
        $this->error("Erreur lors de l'envoi du message");
        $this->redirect('/collection');
    }
}