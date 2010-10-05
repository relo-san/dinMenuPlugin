<?php

/*
 * This file is part of the dinMenuPlugin package.
 * (c) 2010 IF Solutions
 * All rights reserved.
 */

/**
 * Plugin class for performing query and update operations for DinMenuItem model table
 * 
 * @package     dinMenuPlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class PluginDinMenuItemTable extends dinDoctrineTable
{

    /**
     * Returns an instance of PluginDinMenuItemTable
     * 
     * @return  PluginDinMenuItemTable
     */
    public static function getInstance()
    {

        return Doctrine_Core::getTable( 'PluginDinMenuItem' );

    } // PluginDinMenuItemTable::getInstance()


    /**
     * Create menu tree query
     * 
     * @param   string  $alias  Alias for component
     * @return  Doctrine_Query
     */
    public function createMenuTreeQuery( $alias = '' )
    {

        return $this->addQuery( $this->createQuery( $alias ) )->joinI18n()
            ->addSelect( array( 'id', 'is_public', 'uri', 'module', 'action', 'icon', 'level', 'title' ) )
            ->free();

    } // PluginDinMenuItemTable::createMenuTreeQuery()


    /**
     * Get root menu item
     * 
     * @param   string  $application    Application name
     * @param   string  $name           Menu name
     * @return  DinMenuItem
     */
    public function getRootItem( $application, $name )
    {

        return $this->createQuery( 'a' )
            ->leftJoin( 'a.Menu m' )->addWhere( 'm.application = ?', $application )
            ->addWhere( 'm.name = ?', $name )->orderBy( 'root_id, lft' )->fetchOne();

    } // PluginDinMenuItemTable::getRootItem()

} // PluginDinMenuItemTable

//EOF