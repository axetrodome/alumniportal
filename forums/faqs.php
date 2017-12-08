<?php
require_once '../vendor/fzaninotto/faker/src/autoload.php';
$db = new PDO('mysql:host=localhost;dbname=alumniportal','root','');
// alternatively, use another PSR-0 compliant autoloader (like the Symfony2 ClassLoader for instance)

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();
// $db->query('DELETE FROM comments');
// generate data by accessing properties
$time = time();
// for ($i=0; $i < 10; $i++) {
//   $db->query("INSERT INTO comments(user_id,post_id,comment,is_approved,time_elapsed)VALUES('{$faker->numberBetween($min = 14, $max = 15)}','{$faker->numberBetween($min = 24, $max = 33)}','{$faker->sentence}','{$faker->numberBetween($min = 0, $max = 1)}','{$time}')");
// }
// $date = date('Y-m-d');
// for ($i=0; $i < 10; $i++) {
//   $db->query("INSERT INTO posts(title,content,posted,type,image,time_elapsed)VALUES('{$faker->sentence}','{$faker->paragraphs($nb = 3, $asText = false)}',{$date},'events','{$faker->imageUrl($width, $height, 'cats')}','{$time}')");
// }