<?php
namespace Eleadtech\AdvancePromotion\Plugin\Controller\Admin\Promo\Quote\Save;
class CheckFormat {
    protected $helper;
    protected $messageManager;
    protected $redirect;
    public function __construct(
        \Eleadtech\AdvancePromotion\Helper\Data $helper,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ){
        $this->helper = $helper;
        $this->messageManager = $messageManager;
    }
    public function aroundExecute(
        $subject, $process
    ) {
        $simpleAction = $subject->getRequest()->getParam("simple_action");
        $ruleId = $subject->getRequest()->getParam("rule_id");
        if($simpleAction == "buy-more-discount-more"){
            $formula = $subject->getRequest()->getParam("formula");
            if(empty($this->helper->parseFormulaFormat($formula))){
                $this->messageManager->addErrorMessage(__("%1 is not correct format", $formula));
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $url = $objectManager->create('Magento\Backend\Model\UrlInterface');
                $redirectUrl = $url->getUrl('sales_rule/*/edit', ['id' => $ruleId]);
                return $subject->getResponse()->setRedirect($redirectUrl);
            }
        }
        return $process();
    }
}
