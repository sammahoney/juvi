<?php
/**
 * Juvi_Gemstones extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Juvi
 * @package        Juvi_Gemstones
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Gemstones module install script
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('juvi_gemstones/gemstone'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Gemstone ID'
    )
    ->addColumn(
        'stone_name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Stone Name'
    )
    ->addColumn(
        'stone_origin',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Stone Origin'
    )
    ->addColumn(
        'stone_description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(
            'nullable'  => false,
        ),
        'Stone Description'
    )
    ->addColumn(
        'stone_image',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Stone Image'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Enabled'
    )
    ->addColumn(
        'url_key',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'URL key'
    )
    ->addColumn(
        'meta_title',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Meta title'
    )
    ->addColumn(
        'meta_keywords',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Meta keywords'
    )
    ->addColumn(
        'meta_description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Meta description'
    )
    ->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Gemstone Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Gemstone Creation Time'
    ) 
    ->setComment('Gemstone Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
    ->newTable($this->getTable('juvi_gemstones/gemstone_product'))
    ->addColumn(
        'rel_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned'  => true,
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Relation ID'
    )
    ->addColumn(
        'gemstone_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ),
        'Gemstone ID'
    )
    ->addColumn(
        'product_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ),
        'Product ID'
    )
    ->addColumn(
        'position',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'nullable'  => false,
            'default'   => '0',
        ),
        'Position'
    )
    ->addIndex(
        $this->getIdxName(
            'juvi_gemstones/gemstone_product',
            array('product_id')
        ),
        array('product_id')
    )
    ->addForeignKey(
        $this->getFkName(
            'juvi_gemstones/gemstone_product',
            'gemstone_id',
            'juvi_gemstones/gemstone',
            'entity_id'
        ),
        'gemstone_id',
        $this->getTable('juvi_gemstones/gemstone'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addForeignKey(
        $this->getFkName(
            'juvi_gemstones/gemstone_product',
            'product_id',
            'catalog/product',
            'entity_id'
        ),
        'product_id',
        $this->getTable('catalog/product'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addIndex(
        $this->getIdxName(
            'juvi_gemstones/gemstone_product',
            array('gemstone_id', 'product_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('gemstone_id', 'product_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->setComment('Gemstone to Product Linkage Table');
$this->getConnection()->createTable($table);
$this->addAttribute(
    'catalog_product',
    'gemstone_detail',
    array(
        'group'             => 'General',
        'backend'           => '',
        'frontend'          => '',
        'class'             => '',
        'default'           => '',
        'label'             => 'Gemstone',
        'input'             => 'select',
        'type'              => 'int',
        'source'            => 'juvi_gemstones/gemstone_source',
        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'is_visible'        => 1,
        'required'          => 0,
        'searchable'        => 0,
        'filterable'        => 0,
        'unique'            => 0,
        'comparable'        => 0,
        'visible_on_front'  => 0,
        'user_defined'      => 1,
    )
);
$this->endSetup();
