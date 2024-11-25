<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $cars = [
            [
              "make" => "Jaguar",
              "model" => "E-Type",
              "price" => "£250,000",
              "image_url" => "https://assets.bwbx.io/images/users/iqjWHBFdfxIU/i1nHnEfZ0oDM/v1/-1x-1.webp"
            ],
            [
              "make" => "Lamborghini",
              "model" => "Miura",
              "price" => "£2,400,000",
              "image_url" => "https://www.amalgamcollection.com/cdn/shop/files/1_6bb1d71e-56c6-4fc3-9fb6-bafd96a11659_grande.jpg?v=1711023144"
            ],
            [
              "make" => "Alfa Romeo",
              "model" => "Stradale",
              "price" => "£1,000,000",
              "image_url" => "https://cdn.motor1.com/images/mgl/7kyep/s1/alfa-romeo-33-stradale-supercar-sunday.webp"
            ],
            [
              "make" => "Aston Martin",
              "model" => "DB5",
              "price" => "£1,000,000",
              "image_url" => "https://car-images.bauersecure.com/wp-images/12917/aston_db5_100.jpg"
            ],
            [
              "make" => "Ferrari",
              "model" => "F40",
              "price" => "£2,000,000",
              "image_url" => "https://radical-mag.com/wp-content/uploads/2022/12/F40-77676-1-1-1920x1280.jpeg"
            ]
        ];

        Car::insert($cars);
    }
}
