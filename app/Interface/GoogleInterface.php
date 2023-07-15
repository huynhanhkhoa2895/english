<?php
namespace App\Interface;

interface GoogleInterface{
    function callApiGoogle(string $text, string $name,string $disk): bool;
}
