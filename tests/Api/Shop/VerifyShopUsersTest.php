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

namespace Sylius\Tests\Api\Shop;

use Sylius\Tests\Api\JsonApiTestCase;
use Sylius\Tests\Api\Utils\ShopUserLoginTrait;
use Symfony\Component\HttpFoundation\Response;

final class VerifyShopUsersTest extends JsonApiTestCase
{
    use ShopUserLoginTrait;

    /** #test / temporarily disabled as validation triggers before processors */
    public function it_resends_account_verification_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'cart.yaml', 'authentication/shop_user.yaml']);
        $header = array_merge($this->logInShopUser('oliver@doe.com'), self::CONTENT_TYPE_HEADER);

        $this->client->request(
            method: 'POST',
            uri: '/api/v2/shop/verify-shop-user',
            server: $header,
            content: '{}',
        );

        $response = $this->client->getResponse();

        $this->assertResponseCode($response, Response::HTTP_ACCEPTED);
        self::assertEmailCount(1);
        self::assertEmailAddressContains(self::getMailerMessage(), 'To', 'oliver@doe.com');
    }

    /** @test */
    public function it_does_not_allow_to_resend_token_for_not_logged_in_users(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'cart.yaml', 'authentication/shop_user.yaml']);

        $this->client->request(
            method: 'POST',
            uri: '/api/v2/shop/verify-shop-user',
            server: self::CONTENT_TYPE_HEADER,
        );

        $response = $this->client->getResponse();

        $this->assertResponseCode($response, Response::HTTP_UNAUTHORIZED);
        self::assertEmailCount(0);
    }
}