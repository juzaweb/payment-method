<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\PaymentMethod\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Traits\ResourceModel;

/**
 * Juzaweb\Ecommerce\Models\PaymentMethod
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property array|null $data
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read int|null $order_count
 * @method static Builder|PaymentMethod newModelQuery()
 * @method static Builder|PaymentMethod newQuery()
 * @method static Builder|PaymentMethod query()
 * @method static Builder|PaymentMethod whereActive($value)
 * @method static Builder|PaymentMethod whereCreatedAt($value)
 * @method static Builder|PaymentMethod whereData($value)
 * @method static Builder|PaymentMethod whereFilter($params = [])
 * @method static Builder|PaymentMethod whereId($value)
 * @method static Builder|PaymentMethod whereName($value)
 * @method static Builder|PaymentMethod whereType($value)
 * @method static Builder|PaymentMethod whereUpdatedAt($value)
 * @method static Builder active()
 * @mixin Eloquent
 */
class PaymentMethod extends Model
{
    use ResourceModel;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $table = 'payment_methods';

    protected string $fieldName = 'name';

    protected $fillable = [
        'type',
        'name',
        'description',
        'data',
        'active',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function scopeWhereActive(Builder $builder): Builder
    {
        return $builder->where('active', '=', self::STATUS_ACTIVE);
    }

    public function scopeWhereInActive(Builder $builder): Builder
    {
        return $builder->where('active', '=', self::STATUS_INACTIVE);
    }
}
