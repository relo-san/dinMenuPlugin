<?php

/*
 * This file is part of the dinMenuPlugin package.
 * (c) 2010 IF Solutions
 * All rights reserved.
 */

/**
 * Plugin class that represents a record of DinMenu model
 * 
 * @package     dinMenuPlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
abstract class PluginDinMenu extends BaseDinMenu
{

    /**
     * Post insert menu
     * 
     * @return  void
     */
    public function postInsert( $event )
    {

        $item = new DinMenuItem();
        $item->setMenuId( $this->getId() )->setIsPublic( true )->setUri( 'root' );
        $item->save();

        $tree = Doctrine_Core::getTable( 'DinMenuItem' )->getTree();
        $tree->createRoot( $item );

    } // PluginDinMenu::postInsert()

} // PluginDinMenu

//EOF