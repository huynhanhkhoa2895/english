<?php
namespace App\Interface;

use App\Models\Practice;
use Illuminate\Support\Collection;

interface PracticeInterface{
    function getList(): Collection;
    function getById(string $id): Practice;
}
