<?php
namespace App\Model;

use Base\Context;

class File
{
    public function getFile()
    {
        $user = new User();
        $db = Context::i()->getDb();
        $query = 'SELECT id, name, photo FROM users';
        $usersFiles = $db->fetchAll($query, __METHOD__);
        debug($usersFiles);
    }
}