<?php

namespace Juzaweb\PaymentMethod\Http\Repositorys;

use \Models\PaymentMethodRepository;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * Class PaymentMethodRepository.
 *
 * @package namespace Juzaweb\PaymentMethod\Http\Repositorys;
 */
class PaymentMethodRepositoryEloquent extends BaseRepositoryEloquent implements CommentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return PaymentMethodRepository::class;
    }
}
