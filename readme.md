# GET EXTENSION

Use modman [Linux](https://github.com/colinmollenhour/modman) | [Windows](https://github.com/khoazero123/modman-php) :

	cd magento_root/
    modman clone http://fgit.fgct.net/vankhoa/M2OverrideCreateInvoice.git
	modman deploy M2OverrideCreateInvoice

Use git:

    git clone http://fgit.fgct.net/vankhoa/M2OverrideCreateInvoice.git
    cp M2OverrideCreateInvoice/* magento_root/


# INSTALLATION

	bin/magento setup:upgrade
	bin/magento setup:di:compile
	bin/magento cache:clean && bin/magento cache:flush
	bin/magento setup:static-content:deploy
