<?php

use \Base\DB;

require "../vendor/autoload.php";


$faker = Faker\Factory::create('ru_RU');
$db = new DB();
$query = "INSERT INTO `users` SET `name` = ?, `age` = ?, `password` = ?, `email` = ?";
$query2 = "INSERT INTO `data` SET `user_id` = ?, `data_name` = ?";
$query3 = "SELECT id FROM users WHERE id=(SELECT MAX(id) FROM users) ";
$userId = $db->fetchOne($query3,__METHOD__);
for ($i = 0, $usId = $userId['id']+1; $i < 100; $i++, $usId++) {
    $db->exec($query, __METHOD__, [
        $faker->firstName(),
        $faker->randomNumber(2),
        $faker->password(),
        $faker->email
    ]);
    for ($j = 0; $j < 10; $j++) {
        $db->exec($query2, __METHOD__, [
            $usId,
            $faker->firstName . '.jpeg'
        ]);
    }
}
