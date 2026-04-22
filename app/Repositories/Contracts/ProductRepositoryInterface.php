<?php

namespace App\Repositories\Contracts;

Interface ProductRepositoryInterface
{
    public function getPopularProducts($limit);

    public function getAllNewProducts();

    public function find($id);

    public function getPrice($ticketId);

    public function searchByName(string $keyword);
}