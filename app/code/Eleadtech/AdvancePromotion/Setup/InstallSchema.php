<?php
namespace Eleadtech\AdvancePromotion\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (version_compare($context->getVersion(), '1.0.0', '<')) {
            if ($installer->tableExists('salesrule')) {
                 $installer->getConnection()->addColumn(
                    $installer->getTable('salesrule'),
                    'formula',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => false,
                        'comment' => 'Formula For By More Get More',
                        'default' => ""
                    ]
                );
            }
        }
        $installer->endSetup();
    }
}
