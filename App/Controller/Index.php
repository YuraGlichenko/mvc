<?php

namespace App\Controller;

use App\Model\File;
use Base\Context;
use Base\Controller as BaseController;
use App\Model\User;
use Base\Image;
use Base\Session;


class Index extends BaseController
{
    public function authAction(){
        $session = Session::instance();
        $user = new User();
        $userData = $_REQUEST;
        $user->loadUser($userData);
        $ret = $user->checkUser(['email' => $user->getEmail(), 'password' => $user->getPasswordHash()]);
        if ($ret) {
            echo 'Авторизовались';
            $session->set('user_id', $ret['id']);
            header('Location: formdata');

        }

    }

    public function getBySortUsersAction()
    {
        $user = new User();
        $user->isUserAuthorized();
        $allUsers= $user->getAllUsers();
        $this->view->alluser = $allUsers;
    }

    public function indexUserAction()
    {
        $session = Session::instance();
        $this->_render = false;
        $data = $_REQUEST;
        $user = new User();
        $user->loadUser($data);
        $ret = $user->checkUser(['email' => $user->getEmail(), 'password' => $user->getPasswordHash()]);
        if ($ret) {
            $session->set('user_id',$ret['id']);
            header('Location: formdata');
            die();
        } else {
            $user->saveUserDb();
            header('Location: formdata');
        }
    }

    public function indexFileAction()
    {
        $file = new File;
        $files = $file->getFile();
        $this->view->files = $files;
    }

    public function registerAction()
    {
        $user = new User;
        $userIdSession = $user->isUserAuthorized();
        if (empty($userIdSession)) {
            $this->needRender();
        } else {
            header('Location: formdata');
            $this->_render = false;
        }
    }

    public function formdataAction()
    {
        $user = new User();
        $sessionId = $user->isUserAuthorized();
        echo $sessionId;
        if (!$sessionId) {
            header('Location: register');
        }
    }

    public function dataAction()
    {
        $user = new User();
        $sessionId = $user->isUserAuthorized();
        echo $sessionId;
        if (!$sessionId) {
            header('Location: register');
        }
        $data['user_id'] = $sessionId;
        $image = new Image();
        if ($_FILES['file']){
            $image->loadFile($_FILES);
            $image->copyImage();
            $data['data_path'] = $image->getFilePath();
            $data['data_name'] = $image->getFileName();
        } else {
            $data['file'] = '';
        }
        $file = new File();
        $file->saveDbFile($data);
    }

}