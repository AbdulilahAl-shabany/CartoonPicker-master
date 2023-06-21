<?php

namespace Database\Seeders;

use App\Models\Cartoon;
use App\Models\Criteria;
use App\Models\CriteriaIndicator;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@admin.com', 'username' => 'admin', 'password' => Hash::make('123456789')],
        ];
        User::insert($users);
        $cartoons = [
            ['cartoon_name' => 'Shaun The Sheep', 'Does not contain elements of violence' => 4, 'Creative' => 4, 'Educating' => 5, 'Entertain' => 4, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/ShaunTheSheep.jpg'],
            ['cartoon_name' => 'Upin dan Ipin', 'Does not contain elements of violence' => 4, 'Creative' => 4, 'Educating' => 4, 'Entertain' => 5, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/UpindanIpin.jpg'],
            ['cartoon_name' => 'Shiva', 'Does not contain elements of violence' => 2, 'Creative' => 4, 'Educating' => 4, 'Entertain' => 3, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/Shiva.jpg'],
            ['cartoon_name' => 'Nussa', 'Does not contain elements of violence' => 4, 'Creative' => 5, 'Educating' => 4, 'Entertain' => 4, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/Nussa.jpg'],
            ['cartoon_name' => 'Doraemon', 'Does not contain elements of violence' => 3, 'Creative' => 4, 'Educating' => 5, 'Entertain' => 4, 'No Pornographic Elements' => 5, 'cartoon_img' => 'images/Doraemon.jpg'],
            ['cartoon_name' => 'Sopo Jarwo', 'Does not contain elements of violence' => 4, 'Creative' => 4, 'Educating' => 4, 'Entertain' => 4, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/SopoJarwo.jpg'],
            ['cartoon_name' => 'Tom And Jerry', 'Does not contain elements of violence' => 2, 'Creative' => 4, 'Educating' => 5, 'Entertain' => 3, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/TomAndJerry.jpg'],
            ['cartoon_name' => 'Ben Ten', 'Does not contain elements of violence' => 2, 'Creative' => 4, 'Educating' => 5, 'Entertain' => 3, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/BenTen.jpg'],
            ['cartoon_name' => 'The Amazing World of Gum Ball', 'Does not contain elements of violence' => 4, 'Creative' => 4, 'Educating' => 4, 'Entertain' => 5, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/TheAmazingWorldofGumBall.jpg'],
            ['cartoon_name' => 'Masha And The Bear', 'Does not contain elements of violence' => 3, 'Creative' => 4, 'Educating' => 4, 'Entertain' => 3, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/MashaAndTheBear.jpg'],
            ['cartoon_name' => 'The Power Puff Girl', 'Does not contain elements of violence' => 2, 'Creative' => 4, 'Educating' => 4, 'Entertain' => 4, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/ThePowerPuffGirl.jpg'],
            ['cartoon_name' => 'My Little Pony', 'Does not contain elements of violence' => 5, 'Creative' => 4, 'Educating' => 5, 'Entertain' => 4, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/MyLittlePony.jpg'],
            ['cartoon_name' => 'Sponge Bob', 'Does not contain elements of violence' => 4, 'Creative' => 4, 'Educating' => 4, 'Entertain' => 4, 'No Pornographic Elements' => 5, 'cartoon_img' => 'images/SpongeBob.jpg'],
            ['cartoon_name' => 'Adventure Time', 'Does not contain elements of violence' => 4, 'Creative' => 5, 'Educating' => 4, 'Entertain' => 4, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/AdventureTime.jpg'],
            ['cartoon_name' => 'We Bare Bears', 'Does not contain elements of violence' => 4, 'Creative' => 4, 'Educating' => 4, 'Entertain' => 4, 'No Pornographic Elements' => 4, 'cartoon_img' => 'images/WeBareBears.jpg'],
        ];
        Cartoon::insert($cartoons);
        $criteriaIndicator = [
            ['criteria_indicator_name' => 'Very important', 'criteria_indicator_value' => 0.5],
            ['criteria_indicator_name' => 'Important', 'criteria_indicator_value' => 0.4],
            ['criteria_indicator_name' => 'Normal', 'criteria_indicator_value' => 0.3],
            ['criteria_indicator_name' => 'Not Very Important', 'criteria_indicator_value' => 0.2],
            ['criteria_indicator_name' => 'Not Very Important at all', 'criteria_indicator_value' => 0.1],
        ];
        CriteriaIndicator::insert($criteriaIndicator);
        $criteria = [
            ['criteria_name' => 'Does not contain elements of violence', 'criteria_type' => 'benefit'],
            ['criteria_name' => 'Creative', 'criteria_type' => 'benefit'],
            ['criteria_name' => 'Educating', 'criteria_type' => 'benefit'],
            ['criteria_name' => 'Entertain', 'criteria_type' => 'benefit'],
            ['criteria_name' => 'No Pornographic Elements', 'criteria_type' => 'benefit'],
        ];
        Criteria::insert($criteria);
    }
}
