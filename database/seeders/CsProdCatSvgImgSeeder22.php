<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CsProdCatSvgImgSeeder extends Seeder
{
    public function run(): void
    {
        $categories = DB::table('productcategory')->where('DelStatus', 1)->get();

        foreach ($categories as $category) {
            $svg = $this->generateSvg($category->ProductCategoryName);

            DB::table('cs_prod_cat_svg_img')->insert([
                'category_id' => $category->ProductCategoryID,
                'svg_icon' => $svg,
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function generateSvg($categoryName)
    {
        $imgPath = $this->getImagePathForCategory($categoryName);

        // Insert an img tag instead of SVG
        return <<<HTML
            <img src="$imgPath" alt="$categoryName" width="60" height="60" />
        HTML;
    }

    private function getImagePathForCategory($name)
    {
        // Map category names to image file names
        $map = [
            'APPLE' => '/images/fruits/apple.png',
            'MANGO' => '/images/fruits/mango.png',
            'CITRUS ORANGE' => '/images/fruits/citrus.png',
            'BERRY' => '/images/fruits/berry.png',
            'GRAPE' => '/images/fruits/grape.png',
            'KIWI' => '/images/fruits/kiwi.png',
            'AVACADO' => '/images/fruits/avocado.png',
            'CHIKKU' => '/images/fruits/chikku.png',
            'CITRUS' => '/images/fruits/citrus.png',
            'CUCCUMBER' => '/images/fruits/cucumber.png',
            'DATES' => '/images/fruits/dates.png',
            'DRAGON' => '/images/fruits/dragon.png',
            'KOYYA' => '/images/fruits/koyya.png', // Assuming guava
            'KABOOL' => '/images/fruits/kabool.png',
            // 'KAKI' => '/images/fruits/kaki.png',
            'KINU ORANGE' => '/images/fruits/kinu_orange.png',
            'WATER MELON' => '/images/fruits/watermelon.png',
            'GUVAVA' => '/images/fruits/guava.png',
            'LONGAN' => '/images/fruits/longan.png',
            'MANGOSTINE' => '/images/fruits/mangosteen.png',
            'MUSAMBI' => '/images/fruits/musambi.png',
            'NELLIKA' => '/images/fruits/nellikai.png',
            'BANANA' => '/images/fruits/banana.png',
            'ORANGE' => '/images/fruits/orange.png',
            'PAPPAYA' => '/images/fruits/papaya.png',
            'PASSION FRUIT' => '/images/fruits/passion_fruit.png',
            'PEACH' => '/images/fruits/peach.png',
            'PEAR' => '/images/fruits/pear.png',
            'PINEAPPLE' => '/images/fruits/pineapple.png',
            'PLUM' => '/images/fruits/plum.png',
            'RAMPUTAN' => '/images/fruits/rambutan.png',
            'ROBESTA' => '/images/fruits/robesta.png', // Confirm this
            'SABARGIL' => '/images/fruits/sabargil.png', // Ice apple / palm fruit
            'SEED' => '/images/fruits/seed.png', // If needed
            'SHAMAM' => '/images/fruits/muskmelon.png',
            'SITHAPAZHAM' => '/images/fruits/custard_apple.png',
            'STRAWBERRY' => '/images/fruits/strawberry.png',
            'SUGARCANE' => '/images/fruits/sugarcane.png',
            'TAMARIND' => '/images/fruits/tamarind.png',
            'VEGITABLE' => '/images/fruits/vegetable.png',
        ];

        // Fallback image
        return $map[$name] ?? '/images/fruits/default.png';
    }

}
