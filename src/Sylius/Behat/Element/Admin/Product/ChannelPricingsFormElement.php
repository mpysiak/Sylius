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

namespace Sylius\Behat\Element\Admin\Product;

use Sylius\Behat\Element\Admin\Crud\FormElement as BaseFormElement;
use Sylius\Behat\Service\DriverHelper;
use Sylius\Component\Core\Model\ChannelInterface;

final class ChannelPricingsFormElement extends BaseFormElement implements ChannelPricingsFormElementInterface
{
    public function specifyPrice(ChannelInterface $channel, string $price): void
    {
        $this->changeTab();
        $this->changeChannelTab($channel->getCode());
        $this->getElement('field_price', ['%channelCode%' => $channel->getCode()])->setValue($price);
    }

    public function specifyOriginalPrice(ChannelInterface $channel, int $originalPrice): void
    {
        $this->changeTab();
        $this->changeChannelTab($channel->getCode());
        $this->getElement('field_original_price', ['%channelCode%' => $channel->getCode()])->setValue($originalPrice);
    }

    public function getPriceForChannel(ChannelInterface $channel): string
    {
        return $this->getElement('field_price', ['%channelCode%' => $channel->getCode()])->getValue();
    }

    public function getOriginalPriceForChannel(ChannelInterface $channel): string
    {
        return $this->getElement('field_original_price', ['%channelCode%' => $channel->getCode()])->getValue();
    }

    public function hasNoPriceForChannel(string $channelName): bool
    {
        return !str_contains($this->getElement('prices')->getHtml(), $channelName);
    }

    public function getChannelPricingValidationMessage(): string
    {
        return $this->getElement('prices_validation_message')->getText();
    }

    protected function getDefinedElements(): array
    {
        return [
            'channel' => '[data-test-channel-code="%channel_code%"]',
            'channel_tab' => '[data-test-channel-tab="%channelCode%"]',
            'channels' => '[data-test-channels]',
            'field_original_price' => '[data-test-original-price-in-channel="%channelCode%"]',
            'field_price' => '[data-test-price-in-channel="%channelCode%"]',
            'prices_validation_message' => '[data-test-missing-channel-price]',
            'side_navigation_tab' => '[data-test-side-navigation-tab="%name%"]',
        ];
    }

    private function changeChannelTab(string $channelCode): void
    {
        if (DriverHelper::isNotJavascript($this->getDriver())) {
            return;
        }

        $this->getElement('channel_tab', ['%channelCode%' => $channelCode])->click();
    }

    private function changeTab(): void
    {
        if (DriverHelper::isNotJavascript($this->getDriver())) {
            return;
        }

        $this->getElement('side_navigation_tab', ['%name%' => 'channel-pricing'])->click();
    }
}