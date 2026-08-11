<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A single quality issue detected on a product during/after the 1C imports.
 *
 * @property string      $product_onec_id
 * @property int|null    $product_id
 * @property string|null $product_title
 * @property string      $type
 * @property string      $severity
 * @property string      $source
 * @property string|null $message
 * @property array|null  $context
 * @property \Illuminate\Support\Carbon|null $resolved_at
 */
final class ProductError extends Model
{
    use HasFactory;

    public const SEVERITY_CRITICAL = 'critical';
    public const SEVERITY_MINOR    = 'minor';

    public const TYPE_MISSING_IMAGES         = 'missing_images';
    public const TYPE_MISSING_PRIMARY_IMAGES = 'missing_primary_images';
    public const TYPE_MISSING_CATEGORY       = 'missing_category';
    public const TYPE_MISSING_BRAND          = 'missing_brand';
    public const TYPE_MISSING_DESCRIPTION    = 'missing_description';
    public const TYPE_MISSING_ATTRIBUTES     = 'missing_attributes';
    public const TYPE_INVALID_NAME_FORMAT    = 'invalid_name_format';

    /**
     * Canonical catalogue of error types → severity. Human labels and
     * messages are localized in resources/lang/{ru,ro}/product_errors.php.
     * Adding a new rule? Register it here and in ProductErrorScanner.
     *
     * @var array<string, string>
     */
    public const TYPE_SEVERITY = [
        self::TYPE_MISSING_IMAGES         => self::SEVERITY_CRITICAL,
        self::TYPE_MISSING_PRIMARY_IMAGES => self::SEVERITY_CRITICAL,
        self::TYPE_MISSING_CATEGORY       => self::SEVERITY_CRITICAL,
        self::TYPE_MISSING_BRAND          => self::SEVERITY_CRITICAL,
        self::TYPE_MISSING_DESCRIPTION    => self::SEVERITY_MINOR,
        self::TYPE_MISSING_ATTRIBUTES     => self::SEVERITY_MINOR,
        self::TYPE_INVALID_NAME_FORMAT    => self::SEVERITY_MINOR,
    ];

    protected $fillable = [
        'product_onec_id',
        'product_id',
        'product_title',
        'type',
        'severity',
        'source',
        'message',
        'context',
        'resolved_at',
    ];

    protected $casts = [
        'context'     => 'array',
        'resolved_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_onec_id', 'onec_id');
    }

    /** @param Builder<ProductError> $query */
    public function scopeUnresolved(Builder $query): Builder
    {
        return $query->whereNull('resolved_at');
    }

    /** @param Builder<ProductError> $query */
    public function scopeCritical(Builder $query): Builder
    {
        return $query->where('severity', self::SEVERITY_CRITICAL);
    }

    /** @param Builder<ProductError> $query */
    public function scopeMinor(Builder $query): Builder
    {
        return $query->where('severity', self::SEVERITY_MINOR);
    }

    public function typeLabel(): string
    {
        return self::labelForType($this->type);
    }

    public function severityLabel(): string
    {
        return self::labelForSeverity($this->severity);
    }

    public function localizedMessage(): string
    {
        $key = "product_errors.messages.{$this->type}";
        $translated = __($key);

        // Fall back to the stored message if no translation exists.
        return $translated === $key ? (string) $this->message : $translated;
    }

    public function isCritical(): bool
    {
        return $this->severity === self::SEVERITY_CRITICAL;
    }

    public static function severityForType(string $type): string
    {
        return self::TYPE_SEVERITY[$type] ?? self::SEVERITY_MINOR;
    }

    public static function labelForType(string $type): string
    {
        $key = "product_errors.types.{$type}";
        $translated = __($key);

        return $translated === $key ? $type : $translated;
    }

    public static function labelForSeverity(string $severity): string
    {
        $key = "product_errors.severities.{$severity}";
        $translated = __($key);

        return $translated === $key ? $severity : $translated;
    }

    /**
     * All known types as type => localized label, for filter dropdowns.
     *
     * @return array<string, string>
     */
    public static function typeOptions(): array
    {
        $options = [];
        foreach (array_keys(self::TYPE_SEVERITY) as $type) {
            $options[$type] = self::labelForType($type);
        }

        return $options;
    }
}
