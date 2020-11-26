<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eleadtech\AdvancePromotion\Model\SalesRule\Rule\Action\Discount;

class Formula extends \Magento\SalesRule\Model\Rule\Action\Discount\AbstractDiscount
{
    protected $helper;
    public function __construct(
        \Magento\SalesRule\Model\Validator $validator,
        \Magento\SalesRule\Model\Rule\Action\Discount\DataFactory $discountDataFactory,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Eleadtech\AdvancePromotion\Helper\Data $helper

    ) {
        $this->validator = $validator;
        $this->discountFactory = $discountDataFactory;
        $this->priceCurrency = $priceCurrency;
        $this->helper = $helper;
    }

    /**
     * @param \Magento\SalesRule\Model\Rule $rule
     * @param \Magento\Quote\Model\Quote\Item\AbstractItem $item
     * @param float $qty
     * @return \Magento\SalesRule\Model\Rule\Action\Discount\Data
     */

    public function calculate($rule, $item, $qty)
    {

        /** @var \Magento\SalesRule\Model\Rule\Action\Discount\Data $discountData */
        $discountData = $this->discountFactory->create();
        $itemPrice = $this->validator->getItemPrice($item);
        $baseItemPrice = $this->validator->getItemBasePrice($item);
        $itemOriginalPrice = $this->validator->getItemOriginalPrice($item);
        $baseItemOriginalPrice = $this->validator->getItemBaseOriginalPrice($item);
        $formula = $rule->getFormula();
        $formatFormula = $this->helper->getFormulaFormat($formula);
        $discountQty   = 0;
        $discountItemPrice         = 0;
        $discountBaseItemPrice     = 0;
        $discountItemOriginalPrice = 0;
        $discountBaseItemOriginalPrice = 0;
        if(!empty($formatFormula)){
            foreach ($formatFormula as $item){
                if($qty < $item[0]){
                    return $discountData;
                }
                else{
                    $discountItemPrice = @$item[1] * @$item[2]/100 * $itemPrice;
                    $discountBaseItemPrice = @$item[1] * @$item[2]/100 * $baseItemPrice;
                    $discountItemOriginalPrice = @$item[1] * @$item[2]/100 * $itemOriginalPrice;
                    $discountBaseItemOriginalPrice = @$item[1] * @$item[2]/100 * $baseItemOriginalPrice;
                    $discountData->setAmount($discountItemPrice);
                    $discountData->setBaseAmount($discountBaseItemPrice);
                    $discountData->setOriginalAmount($discountItemOriginalPrice);
                    $discountData->setBaseOriginalAmount($discountBaseItemOriginalPrice);
                }
            }
            return $discountData;
        }
        /*
        $x = $rule->getDiscountStep();
        $y = $rule->getDiscountAmount();

        if (!$x || $y > $x) {
            return $discountData;
        }

        $buyAndDiscountQty = $x + $y;

        $fullRuleQtyPeriod = floor($qty / $buyAndDiscountQty);
        $freeQty = $qty - $fullRuleQtyPeriod * $buyAndDiscountQty;

        $discountQty = $fullRuleQtyPeriod * $y;
        if ($freeQty > $x) {
            $discountQty += $freeQty - $x;
        }
        */
        //$discountQty = 0;
        $discountData->setAmount($discountQty * $itemPrice);
        $discountData->setBaseAmount($discountQty * $baseItemPrice);
        $discountData->setOriginalAmount($discountQty * $itemOriginalPrice);
        $discountData->setBaseOriginalAmount($discountQty * $baseItemOriginalPrice);

        return $discountData;
    }
    protected function formula(){

    }
}
