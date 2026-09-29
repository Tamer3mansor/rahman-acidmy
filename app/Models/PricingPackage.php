<?php

namespace App\Models;

use Database\Factories\PricingPackageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPackage extends Model
{
    /** @use HasFactory<PricingPackageFactory> */
    use HasFactory;

    public const TYPE_PER_HOUR = 'per_hour';

    public const TYPE_SPECIAL = 'special';

    /** Duration in minutes → multiplier of the hourly rate. */
    public const DURATIONS = [
        30 => 0.5,
        45 => 0.75,
        60 => 1.0,
    ];

    public const PRICING_TYPES = [
        self::TYPE_PER_HOUR => 'تسعير عام',
        self::TYPE_SPECIAL => 'تسعير خاص',
    ];

    /** Badge wording used on the card when no custom text is set. */
    public const DEFAULT_OFFER_BADGE_TEXT = 'Offre spéciale';

    protected $fillable = [
        'name',
        'badge',
        'badge_style',
        'description',
        'classes_count',
        'pricing_type',
        'price',
        'show_offer_design',
        'offer_badge_text',
        'features',
        'button_label',
        'whatsapp_url',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'classes_count' => 'integer',
        'pricing_type' => 'string',
        'price' => 'float',
        'show_offer_design' => 'boolean',
        'offer_badge_text' => 'string',
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * The hourly rate used to price this package:
     * the global hourly rate for general pricing, or the package's special rate.
     */
    public function hourlyRate(): float
    {
        if ($this->pricing_type === static::TYPE_SPECIAL) {
            return round((float) $this->price, 2);
        }

        return round(PricingSettings::singleton()->per_hour_price, 2);
    }

    /**
     * Total price for the given lesson duration (in hours).
     * Defaults to a 60-minute lesson (full hourly rate).
     */
    public function effectivePrice(float $durationHours = 1.0): float
    {
        return round($this->classes_count * $durationHours * $this->hourlyRate(), 2);
    }

    public function ratePerLesson(float $durationHours = 1.0): float
    {
        if ($this->classes_count < 1) {
            return $this->effectivePrice($durationHours);
        }

        return round($this->effectivePrice($durationHours) / $this->classes_count, 2);
    }

    /**
     * What this package would cost at the general hourly rate — used to
     * strike through the regular price on offer (special) packages.
     */
    public function generalPrice(float $durationHours = 1.0): float
    {
        return round($this->classes_count * $durationHours * PricingSettings::singleton()->per_hour_price, 2);
    }

    /**
     * A package shows the discount design only when it is priced specially
     * *and* the editor has switched the design on. The special rate still
     * applies either way — the flag only controls the badge and the struck
     * through general price.
     */
    public function isOffer(): bool
    {
        return $this->pricing_type === static::TYPE_SPECIAL
            && (bool) $this->show_offer_design;
    }

    /**
     * Wording for the offer badge, falling back to the shared default when the
     * editor left the field empty.
     */
    public function offerBadgeText(): string
    {
        $text = trim((string) $this->offer_badge_text);

        return $text !== '' ? $text : static::DEFAULT_OFFER_BADGE_TEXT;
    }

    public function whatsappPhone(): string
    {
        $phone = trim((string) parse_url((string) $this->whatsapp_url, PHP_URL_PATH), '/');

        return $phone !== '' && preg_match('/^\d+$/', $phone) ? $phone : '';
    }
}
