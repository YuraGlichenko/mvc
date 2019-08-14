<?php
namespace App\Model;

use Base\Context;

class User
{
    private $_id;
    private $_name;
    private $_email;
    private $_passwordHash;
    private $_age;
    private $_password;
    private $_description;
    private $_photo;
    function passwordHash($password)
    {
        $this->_password = $password;
        $this->_passwordHash = sha1('32fdfds/.s' . $password);
    }


    public function save()
    {
        $q = "INSERT INTO users (`name`, age, description, photo, password, email) VALUES (:name, :age, :description, :photo, :pass, :email)";
        $db = Context::i()->getDb();
        $res = $db->exec($q, __METHOD__,
            ['name' => $this->_name,
            'age' => intval($this->_age),
            'description' => $this->_description,
            'photo' => $this->_photo,
            'pass' => $this->_passwordHash,
            'email' => $this->_email]);

        if (!$res) {
            return false;
        }

        $id = $db->lastInsertId();
        $this->_id = $id;
        return true;
    }

    public function userInfo($email, $all = false)
    {
        $db = Context::i()->getDb();
        if ($all) {
            $query = "SELECT * FROM users WHERE email = :email";
        } else {
            $query = "SELECT id FROM users WHERE email = :email";
        }
        $res = $db->fetchOne($query,__METHOD__, ['email' => $email]);
        if (!$res) {
            return '';
        }
        $this->loadUser($res);
    }

    public function loadUser($data)
    {
        $this->_id = $data['id'] ?? '';
        $this->_name = $data['name'] ?? '';
        $this->_password = $this->passwordHash($data['password']) ?? '';
        $this->_email = $data['email'] ?? '';
        $this->_photo = $data['photo'] ?? '';
        $this->_description = $data['description'] ?? '';
        $this->_age =  intval($data['age']) ?? '';
    }

    public function getUserFiles()
    {
        $id = $this->_id;
        $db = Context::i()->getDb();
        $query = "select photo FROM users WHERE id = :id";
        $res = $db->fetchAll($query,__METHOD__,['id' => $id]);
        if ($res){
            echo 'ok';
            return $res;
        }
        return false;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->_photo;
    }

}