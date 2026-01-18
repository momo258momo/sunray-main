<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("
        INSERT INTO products (id, name, slug, short_description, long_description, category, price, image_url, is_featured, on_sale) VALUES
            (1, 'Classic Black Sunglasses', 'classic-black-sunglasses', 'Timeless black frame suitable for any occasion.', 'Enhance your style with these classic black sunglasses. The timeless black frame makes them suitable for any occasion, adding a touch of sophistication to your look. Whether you\'re heading to a casual outing or a formal event, these sunglasses are a versatile accessory. Protect your eyes in style!', 'sunglasses', 49.99, 'images/sunglasses1.jpg', 1, 0),
            (2, 'Fashion Aviator Sunglasses', 'fashion-aviator-sunglasses', 'Stylish aviator sunglasses with UV protection.', 'Make a fashion statement with these stylish aviator sunglasses. The sleek design and UV protection make them a must-have accessory. Whether you\'re strolling down the street or lounging by the pool, these sunglasses will elevate your look while providing essential eye protection.', 'sunglasses', 69.99, 'images/sunglasses4.jpg', 1, 1),
            (3, 'Sporty Blue Light Glasses', 'sporty-blue-light-glasses', 'Protect your eyes from digital eye strain with these sporty blue light glasses.', 'Stay comfortable during long hours of screen time with these sporty blue light glasses. Designed to protect your eyes from digital eye strain, these glasses are ideal for work or leisure. The sporty design adds a touch of flair to your eyewear collection.', 'sunglasses', 29.99, 'images/sunglasses3.jpg', 0, 0),
            (4, 'Vintage Round Eyeglasses', 'vintage-round-eyeglasses', 'Classic round eyeglasses for a retro look.', 'Achieve a retro-inspired look with these vintage round eyeglasses. The classic design adds a touch of nostalgia to your style, making them a perfect choice for those who appreciate timeless fashion. These eyeglasses combine fashion and function for a stylish and clear-eyed experience.', 'eyeglasses', 59.99, 'images/eyeglasses5.jpg', 0, 1),
            (5, 'Designer Octave Glasses Sunglasses', 'designer-octave-sunglasses', 'Elegant cat-eye sunglasses designed for a chic appearance.', 'Step into the world of elegance with these designer octave glasses sunglasses. The cat-eye design exudes sophistication, making them a perfect accessory for any fashion-forward individual. Elevate your style and protect your eyes with these chic sunglasses.', 'eyeglasses', 79.99, 'images/eyeglasses4.jpg', 1, 1),
            (6, 'Square Matte Black Glasses', 'square-matte-black-glasses', 'Fun and colorful glasses featuring popular cartoon characters for kids.', 'Add a playful touch to your child\'s eyewear collection with these square matte black glasses. Featuring popular cartoon characters, these glasses make wearing eyewear fun for kids. The matte black frame adds a touch of coolness to their look.', 'sunglasses', 39.99, 'images/sunglasses2.jpg', 1, 0),
            (7, 'Coexist Outdoor Glasses', 'coexist-outdoor-glasses', 'Ideal for outdoor activities with polarized lenses for glare reduction.', 'Embrace outdoor activities with confidence wearing these Coexist outdoor glasses. The polarized lenses reduce glare, providing clear vision in bright conditions. Whether you\'re hiking, biking, or simply enjoying nature, these glasses offer both style and functionality for your outdoor adventures.', 'eyeglasses', 89.99, 'images/eyeglasses3.jpg', 1, 0),
            (8, 'Minimalist Metal Frame Glasses', 'minimalist-metal-frame-glasses', 'Sleek and minimalist glasses with a durable metal frame.', 'Achieve a sleek and minimalist look with these glasses featuring a durable metal frame. The minimalist design adds a touch of sophistication to your style, making these glasses a versatile accessory for various occasions. Elevate your eyewear collection with these modern and stylish frames.', 'eyeglasses', 54.99, 'images/eyeglasses1.jpg', 0, 1);    
        ");
    }
}
