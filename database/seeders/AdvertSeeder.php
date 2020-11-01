<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Advert;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdvertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getJson = File::get("database/data/ad.json");
        $decodedAdvert = json_decode($getJson);

        foreach ($decodedAdvert as $dataAdvert) {
            $advert = new Advert();
            $advert->title = $dataAdvert->title;
            $advert->slug = Str::slug($dataAdvert->title);
            $advert->publication_date = $dataAdvert->publication_date;
            $advert->update_date = $dataAdvert->update_date;
            $advert->content = $dataAdvert->content;
            $advert->picture = $dataAdvert->picture;
            $advert->slug_city = Str::slug($dataAdvert->slug_city);
            $advert->slug_subcategory = Str::slug($dataAdvert->slug_subCategory);
            $advert->slug_category = Str::slug($dataAdvert->slug_category);
            $advert->user_id_advert = $dataAdvert->user_id_advert;
            $advert->is_active = $dataAdvert->is_active;
            $advert->save();
        }
    }
}
