<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{

    private $cities_list = [
        ['name' => 'Karachi'],
        ['name' => 'Lahore'],
        ['name' => 'Faisalabad'],
        ['name' => 'Rawalpindi'],
        ['name' => 'Gujranwala'],
        ['name' => 'Peshawar'],
        ['name' => 'Multan'],
        ['name' => 'Saidu Sharif'],
        ['name' => 'Hyderabad City'],
        ['name' => 'Islamabad'],
        ['name' => 'Quetta'],
        ['name' => 'Bahawalpur'],
        ['name' => 'Sargodha'],
        ['name' => 'Sialkot City'],
        ['name' => 'Sukkur'],
        ['name' => 'Larkana'],
        ['name' => 'Chiniot'],
        ['name' => 'Shekhupura'],
        ['name' => 'Rahimyar Khan'],
        ['name' => 'Jhang City'],
        ['name' => 'Dera Ghazi'],
        ['name' => 'Gujrat'],
        ['name' => 'Cantonment'],
        ['name' => 'Bhawana'],
        ['name' => 'Mardan'],
        ['name' => 'Sarai Alamgir'],
        ['name' => 'Shah Latif'],
        ['name' => 'Kasur'],
        ['name' => 'Chakwal'],
        ['name' => 'Mingaora'],
        ['name' => 'Nawabshah'],
        ['name' => 'Kotri'],
        ['name' => 'Sahiwal'],
        ['name' => 'Hafizabad'],
        ['name' => 'Mirpur Khas'],
        ['name' => 'Okara'],
        ['name' => 'Khanewal'],
        ['name' => 'Chilas'],
        ['name' => 'Mandi Burewala'],
        ['name' => 'Jacobabad'],
        ['name' => 'Jhelum'],
        ['name' => 'Saddiqabad'],
        ['name' => 'Kohat'],
        ['name' => 'Muridke'],
        ['name' => 'Muzaffargarh'],
        ['name' => 'Khanpur'],
        ['name' => 'Gojra'],
        ['name' => 'Mandi Bahauddin'],
        ['name' => 'Jaranwala'],
        ['name' => 'Lalian'],
        ['name' => 'Chauk Azam'],
        ['name' => 'Abbottabad'],
        ['name' => 'Turbat'],
        ['name' => 'Dadu'],
        ['name' => 'Khairpur Mir’s'],
        ['name' => 'Bahawalnagar'],
        ['name' => 'Khuzdar'],
        ['name' => 'Pakpattan'],
        ['name' => 'Zafarwal'],
        ['name' => 'Tando Allahyar'],
        ['name' => 'Ahmadpur East'],
        ['name' => 'Vihari'],
        ['name' => 'New Mirpur'],
        ['name' => 'Kamalia'],
        ['name' => 'Kot Addu'],
        ['name' => 'Nowshera'],
        ['name' => 'Swabi'],
        ['name' => 'Parachinar'],
        ['name' => 'Goth Tando'],
        ['name' => 'Khushab'],
        ['name' => 'Dera Ismail'],
        ['name' => 'Bagu Na'],
        ['name' => 'Chaman'],
        ['name' => 'Charsadda'],
        ['name' => 'Kandhkot'],
        ['name' => 'Bahrain'],
        ['name' => 'Chishtian'],
        ['name' => 'Wahga'],
        ['name' => 'Masho Khel'],
        ['name' => 'Saidpur'],
        ['name' => 'Hasilpur'],
        ['name' => 'Attock Khurd'],
        ['name' => 'Kambar'],
        ['name' => 'Arifwala'],
        ['name' => 'Muzaffarabad'],
        ['name' => 'Mianwali'],
        ['name' => 'Jauharabad'],
        ['name' => 'Jalalpur Jattan'],
        ['name' => 'Gwadar'],
        ['name' => 'Bhakkar'],
        ['name' => 'Zhob'],
        ['name' => 'Dipalpur'],
        ['name' => 'Kharian'],
        ['name' => 'Mian Channun'],
        ['name' => 'Bhalwal'],
        ['name' => 'Jamshoro'],
        ['name' => 'Kathri'],
        ['name' => 'Pattoki'],
        ['name' => 'Harunabad'],
        ['name' => 'Kahror Pakka'],
        ['name' => 'Toba Tek'],
        ['name' => 'Samundri'],
        ['name' => 'Shakargarh'],
        ['name' => 'Sambrial'],
        ['name' => 'Shujaabad'],
        ['name' => 'Hujra Shah'],
        ['name' => 'Kabirwala'],
        ['name' => 'Rohri'],
        ['name' => 'Mansehra'],
        ['name' => 'Lala Musa'],
        ['name' => 'Chunian'],
        ['name' => 'Nankana Sahib'],
        ['name' => 'Bannu'],
        ['name' => 'Pasrur'],
        ['name' => 'Timargara'],
        ['name' => 'Rangewala'],
        ['name' => 'Chenab Nagar'],
        ['name' => 'Abdul Hakim'],
        ['name' => 'Hassan Abdal'],
        ['name' => 'Haripur'],
        ['name' => 'Tank'],
        ['name' => 'Hangu'],
        ['name' => 'Jalalabad'],
        ['name' => 'Naushahro Firoz'],
        ['name' => 'Bat Khela'],
        ['name' => 'Risalpur Cantonment'],
        ['name' => 'Karak'],
        ['name' => 'Kundian'],
        ['name' => 'Umarkot'],
        ['name' => 'Chitral'],
        ['name' => 'Batgram'],
        ['name' => 'Dainyor'],
        ['name' => 'Kulachi'],
        ['name' => 'Kalat'],
        ['name' => 'Kotli'],
        ['name' => 'Murree'],
        ['name' => 'Akora'],
        ['name' => 'Mithi'],
        ['name' => 'Mian Sahib'],
        ['name' => 'Nurkot'],
        ['name' => 'Basla'],
        ['name' => 'Gakuch'],
        ['name' => 'Gilgit'],
        ['name' => 'Bunji'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        array_walk($this->cities_list, function ($city) {
            City::create($city);
        });
    }
}