<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\ProductBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Product\Model\ProductOptionValueInterface;
use Sylius\Component\Product\Repository\ProductOptionValueRepositoryInterface;

/**
 * @template T of ProductOptionValueInterface
 *
 * @implements ProductOptionValueRepositoryInterface<T>
 */
class ProductOptionValueRepository extends EntityRepository implements ProductOptionValueRepositoryInterface
{
}