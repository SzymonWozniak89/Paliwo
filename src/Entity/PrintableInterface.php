<?php
namespace App\Entity;

interface PrintableInterface {
    public function getDisplayName(): string;
}