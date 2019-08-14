<?php

namespace App\Controller;

use App\Model\File;
use Base\Controller as BaseController;
use App\Model\User;
use Base\Image;


class Index extends BaseController
{
    public function indexAction()
    {
        if (isUserAuthorized()){

        }
    }

    public function indexUserAction()
    {
        $this->_render = false;
        $user = new User();
        $data = $_REQUEST;
        $image = new Image();
        if ($_FILES['photo']){
            $image->loadFile($_FILES);
            $image->copyImage();
            $data['photo'] = $image->getFilePath();
        } else {
            $data['photo'] = '';
        }

        $user->loadUser($data);
        $ret = $user->save();
        if ($ret) {
            echo 'ok';
            echo $user->getId();
        }
    }

    public function getUserAction()
    {
        $user = new User();
        $user->userInfo('fdghfdh', 1);
        $this->view->userInfo = $user;
    }

    public function indexFileAction()
    {
        $this->_render=false;
        $file = new File;
        $file->getFile();
    }


}