<?php

namespace App\Repositories;

class JsonParser
{
    public function parse($data)
    {
        return json_decode($data, true);
    }
}
