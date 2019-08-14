<?php
/**
 * Created by PhpStorm.
 * User: usr
 * Date: 13.08.2019
 * Time: 23:12
 */

namespace App\Controller;

use App\Model\User;

class info
{
    public function indexUserFiles()
    {
        $user = new User();
        $userId = $user->getId();
        $files = $user->getUserFiles();
    }
}