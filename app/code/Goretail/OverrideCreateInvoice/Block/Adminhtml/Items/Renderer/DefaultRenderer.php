<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Goretail\OverrideCreateInvoice\Block\Adminhtml\Items\Renderer;

/**
 * Order item render block
 *
 * @api
 * @since 100.0.2
 */
class DefaultRenderer extends \Magento\Sales\Block\Adminhtml\Items\Renderer\DefaultRenderer {
	public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\Product $product,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_product = $product;
        $this->_stockItemRepository = $stockItemRepository;
        parent::__construct($context, $stockRegistry, $stockConfiguration, $registry, $data);
	}

    public function getErrorOutStock($item) {
        //$productId = $item->getProductId();
        $sku = $item->getSku();
        $productId = $this->_product->getIdBySku($sku);
        $_productStock = $this->_stockItemRepository->get($productId);
        $qtySelected = intval($item->getQty());
        $qtyProduct = $_productStock->getQty();
        $html = '';
        if(!$_productStock->getIsInStock()) {
            $html = '<div class="message message-error error"><div data-ui-id="messages-message-error">This product is out of stock.</div></div>';
        }elseif($qtySelected > $qtyProduct){
            $html = '<div class="message message-error error"><div data-ui-id="messages-message-error">This product doesn\'t have enough quantity.</div></div>';
        }
        return $html;
    }
}
