<?php
namespace FGCT\OverrideCreateInvoice\Observer;
use Magento\Framework\Event\ObserverInterface;

class OrderInvoiceSaveAfter implements ObserverInterface {
	public $_coreRegistry;
	protected $_helper;
	public function __construct(
		\Magento\Framework\Registry $coreRegistry
	) {
		$this->_coreRegistry = $coreRegistry;
	}
    public function execute(\Magento\Framework\Event\Observer $observer) {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$productsId = $this->_coreRegistry->registry('fgct_overridecreateinvoice_products_out_stock') ?: [];
		if(count($productsId)) {
			$msg = "Some of the products are out of stock";
			//throw new \Exception($msg);
			exit('OrderInvoiceSaveAfter');
		}
	}
}
