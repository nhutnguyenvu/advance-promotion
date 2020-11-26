<?php

namespace Eleadtech\AdvancePromotion\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Eleadtech\Bcore\Helper\Data as BcoreData;


class Data extends BcoreData
{
    protected $logFile = "var/log/advancepromotion.log";
    const ENABLED = "enabled";

    public function writeLog($message)
    {
        parent::writeLog($message);
    }
    public function createGeneralConfigurationPath($name){
        return "advancepromotion/general/".$name;
    }
    public function isEnabled(){
        return $this->getConfigValue($this->createGeneralConfigurationPath(self::ENABLED));
    }
    public function parseFormulaFormat($format){
        if(empty(trim($format))){
            return false;
        }
        $data = [];
        $format = explode("||",$format);
        if(!is_array($format)){
            $format[0] = $format;
        }
        $min = 1;
        foreach ($format as $key => $item){
            $item = explode("-",trim($item));
            if(count($item) == 3){
                foreach ($item as $keyItem=>$element){
                    if(!is_numeric($element)){
                        return false;
                    }
                }
                $data[$key] = $item;
                if($min < $item[0]){
                    $min = $item[0];
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        return $data;
    }
    public function getFormulaFormat($format){
        return $this->parseFormulaFormat($format);
    }
}
