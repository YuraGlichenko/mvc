<?php
namespace App\Model;

use Base\Context;

class File
{
    public function getFile()
    {
        $user = new User();
        $id = $user->isUserAuthorized();

        if (empty($id)) {
            header('Location: register');
        }
        $db = Context::i()->getDb();
        $query = "SELECT * FROM data WHERE user_id = :id";
        $usersFiles = $db->fetchAll($query, __METHOD__, ['id' => intval($id)]);
        return $usersFiles;
    }

    public function saveDbFile($data)
    {
        debug($data);
        $q = "INSERT INTO data (user_id, data_name, data_path) VALUES (:us_id, :data_name, :data_path)";
        $param = ['us_id' => $data['user_id'], 'data_name' => $data['data_name'], 'data_path' => $data['data_path']];
        $db = Context::i()->getDb();
        $ret = $db->exec($q,__METHOD__, $param);
        if ($ret) {
            echo 'ok';
        } else {
            echo ":( not add to db";
        }
    }
}