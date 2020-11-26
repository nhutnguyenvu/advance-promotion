/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Ui/js/form/element/abstract',
    'jquery',
    "mage/translate"
], function (AB,$,$t) {
    'use strict';

    return AB.extend({
        defaults: {
            imports: {
                toggleHidden: '${ $.parentName }.simple_action:value'
            },
            elementTmpl: 'Eleadtech_AdvancePromotion/ui/form/element/input'
        },

        /**
         * Toggle element hid state according to simple action value.
         *
         * @param {String} action
         */
        toggleHidden: function (action) {
            switch (action) {
                case 'buy-more-discount-more':
                    this.showFormula();
                    break;
                default:
                    this.hideFormula();
            }
        },
        processHidden: function (){
            if($("[name='simple_action']").val()=="buy-more-discount-more"){
                this.showFormula();
            }
            else{
                this.hideFormula();
            }
            this.addNotice();
        },
        addNotice: function(){
            var text = $t("Formula: x1-y1-z1||x2-y2-z2") + "<br/>" + "x1,x2: qty of products that customer need to buy to get the discount achivement" + "<br/>" + "y1,y2: qty of products will get discount" + "<br/>" + "z1,z2: the discount rate";
            text +=  "<br/>" + "<br/>" + "Example: 20-5-7||30-6-10||35-9-15" +  "<br/>" + "By over 20 products, get 5 discount products with 7%" + "<br/>" + "By over 30 products, get 6 discount products with 10%" + "<br/>" + "By over 40 products, get 9 discount products with 15%";
            $("[data-index='formula']").find(".admin__field-note span").html(text);
        },
        showFormula: function(){
            $("[data-index='discount_amount']").hide();
            $("[data-index='discount_qty']").hide();
            $("[data-index='discount_step']").hide();
            $("[data-index='formula']").show();
        },
        hideFormula: function(){
            $("[data-index='discount_amount']").show();
            $("[data-index='discount_qty']").show();
            $("[data-index='discount_step']").show();
            $("[data-index='formula']").hide();
        }
    });
});
