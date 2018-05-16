<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace FGCT\OverrideCreateInvoice\Block\Adminhtml\Items\Renderer;

use Magento\Sales\Model\Order\CreditMemo\Item as CreditMemoItem;
use Magento\Sales\Model\Order\Invoice\Item as InvoiceItem;
use Magento\Sales\Model\Order\Item as OrderItem;

/**
 * Order item render block
 *
 * @api
 * @since 100.0.2
 */
class DefaultRenderer extends \Magento\Sales\Block\Adminhtml\Items\Renderer\DefaultRenderer {
	public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $stockRegistry, $stockConfiguration, $registry, $data);
	}

    public function getErrorOutStock($productId) {
        $productsId = explode(',',$this->getRequest()->getParam('productsId'));
		if(in_array($productId, $productsId)) {
            $html = '<div id="messages"><div class="messages"><div class="message message-error error"><div data-ui-id="messages-message-error">This product is out of stock</div></div></div></div>';
            return $html;
        }
    }
}
