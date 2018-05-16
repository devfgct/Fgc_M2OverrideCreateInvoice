<?php
namespace FGCT\OverrideCreateInvoice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

use Magento\Framework\Controller\ResultFactory;

class OrderInvoiceSaveBefore implements ObserverInterface {
	public $_coreRegistry;
	protected $_helper;
	public function __construct(
		\Magento\Framework\Registry $coreRegistry,
		\Magento\Framework\App\RequestInterface $request,
		\Magento\Framework\App\ResponseFactory $responseFactory,
		\Magento\Framework\Message\ManagerInterface $messageManager,
		\Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        \Magento\Framework\UrlInterface $url
	) {
		$this->_coreRegistry = $coreRegistry;
		$this->_request = $request;
		$this->responseFactory = $responseFactory;
        $this->url = $url;
		$this->_messageManager = $messageManager;
		$this->_stockItemRepository = $stockItemRepository;
	}
    public function execute(\Magento\Framework\Event\Observer $observer) {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$orderId = $this->_request->getParam('order_id');
		$invoice = $observer->getEvent()->getInvoice();
		// $order = $invoice->getOrder();
		$productManager = $objectManager->create('Magento\Catalog\Model\Product');
		$productsOutStock = $productsNotEnoughQty = [];
		foreach ($invoice->getAllItems() as $item) {
			$name = $item->getName();
			// $type = $item->getSku();
			$productId = $item->getProductId();
			$qty = $item->getQty();
			// $product = $productManager->load($productId);
			$_productStock = $this->_stockItemRepository->get($productId);
			// $_productStock->getQty();
			if(!$_productStock->getIsInStock()) {
				$productsOutStock[$productId] = $name;
			}
			if($qty > $_productStock->getQty()) {
				$productsNotEnoughQty[$productId] = $_productStock->getQty();
			}
		}
		if(count($productsOutStock)) {
			$productsId = array_keys($productsOutStock);
			$this->_coreRegistry->register('fgct_overridecreateinvoice_products_out_stock', $productsId, true);
			$this->_messageManager->addError(__('Some of the products are out of stock'));

			$redirectionUrl = $this->url->getUrl('sales/order_invoice/new/*/product/*/', ['order_id' => $orderId, 'productsId' => implode(',', $productsId)]);
			$this->responseFactory->create()->setRedirect($redirectionUrl)->sendResponse();
			return $this;
		}
	}
}
