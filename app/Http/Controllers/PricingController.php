<?php

namespace App\Http\Controllers;

use App\Models\LandingSettings;
use App\Models\PricingPackage;
use App\Models\PricingSettings;
use App\Models\SystemSettings;

class PricingController extends Controller
{
    public function index()
    {
        $settings = LandingSettings::singleton();

        $packages = PricingPackage::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('price.index', [
            'settings' => $settings,
            'pricing' => $pricing = PricingSettings::singleton(),
            'packages' => $packages,
            'isIndexed' => $pricing->is_indexed,
            'defaultWaPhone' => $this->resolveDefaultWhatsAppPhone(),
        ]);
    }

    private function resolveDefaultWhatsAppPhone(): string
    {
        $number = SystemSettings::singleton()->whatsappNumberDigits();

        if ($number !== '') {
            return $number;
        }

        return $this->resolveWhatsAppPhone(LandingSettings::singleton()->header_btn1_url);
    }

    private function resolveWhatsAppPhone(?string $url): string
    {
        $phone = trim((string) parse_url((string) $url, PHP_URL_PATH), '/');

        return $phone !== '' && preg_match('/^\d+$/', $phone) ? $phone : '';
    }
}
