<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
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
        $emojiOrPath = $this->getEmojiForCategory($categoryName);

        // If it looks like an image path
        if (str_starts_with($emojiOrPath, '/images/')) {
            // Generate full URL for the image (important!)
            $imageUrl = url($emojiOrPath);

            return <<<SVG
                <svg width="60" height="60" xmlns="http://www.w3.org/2000/svg">
                    <image href="$imageUrl" x="0" y="0" height="60" width="60" />
                </svg>
            SVG;
        } else {
            // Render emoji as text
            return <<<SVG
                <svg width="60" height="60" xmlns="http://www.w3.org/2000/svg">
                    <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle"
                        font-size="28" font-family="Segoe UI Emoji, Apple Color Emoji, sans-serif">
                        $emojiOrPath
                    </text>
                </svg>
            SVG;
        }
    }

    private function getEmojiForCategory($name)
    {
        $map = [
            'APPLE' => '🍎',
            'MANGO' => '🥭',
            'CITRUS ORANGE' => '🍊',
            'BERRY' => '🫐',
            'GRAPE' => '🍇',
            'KIWI' => '🥝',
            'AVACADO' => '🥑',
            'CHIKKU' => '/images/fruits/chikku.png',
            'CITRUS' => '🍋',
            'CUCCUMBER' => '🥒',
            'DATES' => '/images/fruits/dates.png',
            'DRAGON' => '/images/fruits/dragon.png',
            'KOYYA' => '/images/fruits/koyya.png',
            'KABOOL' => '/images/fruits/kabool.png',
            'KAKI' => '🍑', // Persimmon is Kaki in some places, peach as close
            'KINU ORANGE' => '🍊',
            'WATER MELON' => '🍉',
            'GUVAVA' => '/images/fruits/koyya.png',
            'LONGAN' => '/images/fruits/longan.png',
            'MANGOSTINE' => '/images/fruits/mangosteen.png',
            'MUSAMBI' => '🍋',
            'NELLIKA' => '/images/fruits/gooseberry.png',
            'BANANA' => '🍌',
            'ORANGE' => '🍊',
            'PAPPAYA' => '/images/fruits/papaya.png',
            'PASSION FRUIT' => '/images/fruits/passion_fruit.png',
            'PEACH' => '🍑',
            'PEAR' => '🍐',
            'PINEAPPLE' => '🍍',
            'PLUM' => '/images/fruits/plum.png',
            'RAMPUTAN' => '/images/fruits/rambutan.png',
            'ROBESTA' => '🍌', // Assuming it's a grape type
            'SABARGIL' => '/images/fruits/sabargil.png',
            'SEED' => '🌱',
            'SHAMAM' => '/images/fruits/muskmelon.png',
            'SITHAPAZHAM' => '/images/fruits/custard_apple.png',
            'STRAWBERRY' => '🍓',
            'SUGARCANE' => '🎋', // Bamboo as sugarcane visual
            'TAMARIND' => '/images/fruits/tamarind.png',
            'VEGITABLE' => '🥦', // General vegetable emoji
        ];

        // Fallback: use 🧺 (basket) or 🏷️ (tag) emoji
        return $map[$name] ?? '🧺';
    }

}
