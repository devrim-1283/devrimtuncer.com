<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'instagram_url' => '',
            'twitter_url' => '',
            'r10_url' => '',
            'fiverr_url' => '',
            'linkedin_url' => '',
            'phone' => '',
            'whatsapp' => '',
            'email' => 'info@devrimtuncer.com',
            'cv_file' => '',
            'vision_tr' => 'Teknoloji ile hayatı kolaylaştırmak ve dijital dönüşümde öncü olmak.',
            'vision_en' => 'To make life easier with technology and be a pioneer in digital transformation.',
            'mission_tr' => 'Kaliteli, hızlı ve güvenilir yazılım çözümleri sunarak müşterilerimizin başarısına katkıda bulunmak.',
            'mission_en' => 'To contribute to our customers\' success by providing quality, fast and reliable software solutions.',
            'why_me_tr' => "• Hızlı Teslimat: Projelerinizi zamanında teslim ediyorum.\n• Ödeme Sistemi: Ürünü teslim etmeden ödeme almıyoruz.\n• Ürünün Arkasındayız: Teslim sonrası da destek sağlıyoruz.\n• 7/24 Destek: Her zaman yanınızdayız.",
            'why_me_en' => "• Fast Delivery: I deliver your projects on time.\n• Payment System: We don't take payment before delivering the product.\n• We Stand Behind Our Product: We provide support after delivery.\n• 24/7 Support: We are always with you.",
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
