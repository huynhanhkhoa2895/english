<?php
namespace App\Interface;

use App\Http\Resources\StudentResource;
use Illuminate\Support\Collection;

interface StudentInterface{
    function getList(): Collection;
    function getById(string $id): StudentResource|false;
}
