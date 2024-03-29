<?php

namespace App\Model;

use Base\Context;
use Base\Session;

class User
{
    private $_id;
    private $_name;
    private $_email;
    private $_passwordHash;
    private $_age;
    private $_password;
    private $_passwordSec;

    /**
     * @return mixed
     */
    public function getPasswordHash()
    {
        return $this->_passwordHash;
    }

    private function passwordHash($password)
    {
        $this->_passwordSec = $password;
        $this->_passwordHash = sha1('32fdfds/.s' . $password);
    }

    public function getAllUsers($sortByInc = false)
    {
        $user = new User();
        $id = $user->getId();
        $db = Context::i()->getDb();
        $query = "SELECT `name`, age, CASE WHEN age > 18 THEN 'совершенолетний' WHEN age < 18 THEN 'несовершеннолетний' END as `maturity` FROM users";
        if ($sortByInc) {
            $query .= " order by age ASC";
        } else {
            $query .= " order by age DESC";
        }
        $res = $db->fetchAll($query, __METHOD__);
        if ($res) {
            return $res;
        }
        return false;
    }


    public function checkUser($data)
    {
        debug($data);
        $q = "SELECT id FROM users WHERE email = :email and password = :pass";
        $p = ['email'=>$data['email'], 'pass' => $data['password']];
        $db = Context::i()->getDb();
        $res = $db->fetchOne($q, __METHOD__, $p);
        if ($res) {
            return $res;
        } else {
            return '';
        }
    }

    public function saveUserDb()
    {
        $q = "INSERT INTO users (`name`, age, password, email) VALUES (:name, :age, :pass, :email)";
        $db = Context::i()->getDb();
        $res = $db->exec($q, __METHOD__,
            ['name' => $this->_name,
                'age' => intval($this->_age),
                'pass' => $this->_passwordHash,
                'email' => $this->_email]);

        if (!$res) {
            return false;
        }

        $id = $db->lastInsertId();
        $session = Session::instance();
        $session->set('user_id', $id);
        $this->_id = $id;
        return true;
    }

    function isUserAuthorized()
    {
        $session = Session::instance();
        $userId = $session->get('user_id');
        return $userId;
    }

    public function loadUser($data)
    {
        $this->_id = $data['id'] ?? '';
        $this->_name = $data['name'] ?? '';
        $this->_password = $this->passwordHash($data['password']) ?? '';
        $this->_email = $data['email'] ?? '';
       //$this->_age = intval($data['age']) ?? '';
    }

    public function checkRegistrationForm(&$error = '')
    {
        if (!$this->_name) {
            $error = 'empty name';
            return false;
        }
        return true;
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

}