<?php

/*
 * This file is part of the dinMenuPlugin package.
 * (c) 2010 IF Solutions
 * All rights reserved.
 */

/**
 * Plugin class that represents a record of DinMenuItem model
 * 
 * @package     dinMenuPlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
abstract class PluginDinMenuItem extends BaseDinMenuItem
{

    /**
     * Get parent identifier
     * 
     * @return  integer Parent identifier
     */
    public function getParentId()
    {

        if ( !$this->getNode()->isValidNode() || $this->getNode()->isRoot() )
        {
            return null;
        }
        return $this->getNode()->getParent()->getId();

    } // PluginDinMenuItem::getParentId()


    /**
     * Get indented name
     * 
     * @return  string  Indented title
     */
    public function getIndentedName()
    {

        return str_repeat( '- ', $this->getLevel() ) . $this->getTitle();

    } // PluginDinMenuItem::getIndentedName()

} // PluginDinMenuItem

//EOF