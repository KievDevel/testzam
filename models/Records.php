<?php
/**
 * Created by Svyatoslav Svitlychnyi.
 * Date: 21.07.2015
 * Time: 21:08
 */

namespace Models;


class Records
{
    public function db()
    {
        try {
            $con = new PDO("mysql:host=localhost;dbname=testzam", 'root', '');
        } catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
    }
} 