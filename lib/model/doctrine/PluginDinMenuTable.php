<?php

/*
 * This file is part of the dinMenuPlugin package.
 * (c) 2010 IF Solutions
 * All rights reserved.
 */

/**
 * Plugin class for performing query and update operations for DinMenu model table
 * 
 * @package     dinMenuPlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class PluginDinMenuTable extends dinDoctrineTable
{

    /**
     * Returns an instance of PluginDinMenuTable
     * 
     * @return  PluginDinMenuTable
     */
    public static function getInstance()
    {

        return Doctrine_Core::getTable( 'PluginDinMenu' );

    } // PluginDinMenuTable::getInstance()


    /**
     * Get menu items
     * 
     * @param   array   $params Query params
     * @return  array   Menu tree
     */
    public function getMenuItems( $params )
    {

        $itemTable = DinMenuItemTable::getInstance();

        $root = $itemTable->getRootItem( $params['application'], $params['name'] );

        $tree = $itemTable->getTree();
        $tree->setBaseQuery( $itemTable->createMenuTreeQuery() );

        return $this->createTree( $root, 'items' );

    } // PluginDinMenuTable::getMenuItems()


    /**
     * Create tree
     * 
     * @param   DinMenuItem $item
     * @param   string      $nesting    Nesting key name [optional]
     * @return  array   Tree in array representation
     */
    protected function createTree( $item, $nesting = 'items' )
    {

        $lang = sfContext::getInstance()->getUser()->getCulture();
        $items = array();
        $node = $item->getNode();
        if ( $node->hasChildren() )
        {
            foreach ( $node->getChildren() as $children )
            {
                if ( $children['is_public'] )
                {
                    $items[] = $this->createTree( $children, $nesting );
                }
            }
        }

        if ( $item['level'] == 0 )
        {
            return $items;
        }

        $out = $item->toArray();
        unset( $out['Menu'], $out['menu_id'], $out['root_id'], $out['lft'], $out['rgt'] );

        if ( !isset( $out['Translation'][$lang] ) && isset( $out['Translation']['en'] ) )
        {
            $out['Translation'][$lang] = $out['Translation']['en'];
        }
        unset( $out['Translation'][$lang]['id'], $out['Translation'][$lang]['lang'] );
        $out = array_merge( $out, $out['Translation'][$lang] );

        unset( $out['Translation'], $out['description'], $out['is_public'] );
        $out[$nesting] = $items;

        return $out;

    } // PluginDinMenuTable::createTree()

} // PluginDinMenuTable

//EOF