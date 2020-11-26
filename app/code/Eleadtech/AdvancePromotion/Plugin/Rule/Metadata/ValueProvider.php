<?php
namespace Eleadtech\AdvancePromotion\Plugin\Rule\Metadata;
class ValueProvider {
    protected $helper = null;
    public function __construct(
        \Eleadtech\AdvancePromotion\Helper\Data $helper
    ){
        $this->helper = $helper;
    }
    public function afterGetMetadataValues(
        \Magento\SalesRule\Model\Rule\Metadata\ValueProvider $subject,
        $result
    ) {
        if(!empty($this->helper->isEnabled())){
            $applyOptions = [
                'label' => __('Advance'),
                'value' => [
                    [
                        'label' => 'Bye More Discount More',
                        'value' => \Eleadtech\AdvancePromotion\Model\SalesRule\Rule\Action\Discount\CalculatorFactory::BUY_MORE_DISCOUNT_MORE
                    ]
                ],
            ];
            array_push($result['actions']['children']['simple_action']['arguments']['data']['config']['options'], $applyOptions);
        }
        return $result;
    }
}
