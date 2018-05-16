<?php

namespace FGCT\OverrideCreateInvoice\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {
	protected $_filesystem;
	protected $_directory_list;
	protected $_resource;
	protected $_scopeConfig;
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\Filesystem $filesystem,
		\Magento\Framework\App\ResourceConnection $resource,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Filesystem\DirectoryList $directory_list
    ) {
		parent::__construct($context);
		$this->_filesystem = $filesystem;
        $this->_directory_list = $directory_list;
		$this->_resource = $resource;
		$this->_scopeConfig = $scopeConfig;
	}
}
