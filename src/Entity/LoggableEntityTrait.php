<?php

namespace App\Entity;

trait LoggableEntityTrait {
    public function logActivity(string $messege){
        dd($messege);
    }
}