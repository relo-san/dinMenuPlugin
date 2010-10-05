<?php

/*
 * This file is part of the dinMenuPlugin package.
 * (c) DineCat, 2010 http://dinecat.com/
 * 
 * For the full copyright and license information, please view the LICENSE file,
 * that was distributed with this package, or see http://www.dinecat.com/din/license.html
 */

/**
 * dinMenuItemAdmin module helper
 * 
 * @package     dinMenuPlugin
 * @subpackage  modules.dinMenuItemAdmin.lib
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class dinMenuItemAdminGeneratorHelper extends BaseDinMenuItemAdminGeneratorHelper
{

    /**
     * Get dictionary name
     * 
     * @return  
     */
    public function getMenuName()
    {

        $menu = DinMenuTable::getInstance()->find(
            sfContext::getInstance()->getRequest()->getParameter( 'menu_id', 1 )
        );
        return $menu->getApplication() . ' &mdash; ' . $menu->getTitle();

    } // dinMenuItemAdminGeneratorHelper::getMenuName()


    /**
     * Get parent folder path
     *
     * @return  string
     */
    public function getRootName()
    {

        $elem = Doctrine::getTable( 'DinMenuItem' )->find(
            sfContext::getInstance()->getRequest()->getParameter( 'id', 1 )
        );
        return $this->getPath( $elem->getNode(), ' &raque; ', false );

    } // dinMenuItemAdminGeneratorHelper::getRootName()


    /**
     * Gets path to node from root
     *
     * @param   Doctrine_Node_NestedSet $node
     * @param   string  $separator      Path separator
     * @param   boolean $includeNode    Include node at end of path
     * @return  string  Items path
     */
    public function getPath( $node, $separator = ' &raque; ', $includeRecord = false )
    {

        $path = array();
        $ancestors = $node->getAncestors();
        if ( $ancestors )
        {
            foreach ( $ancestors as $ancestor )
            {
                $path[] = $ancestor->getTitle();
            }
        }
        else
        {
            $path[] = '';
        }
        if ( $includeRecord )
        {
            $path[] = $node->getRecord()->getTitle();
        }
        unset( $path[0] );
        return implode( $separator, $path );

    } // dinMenuItemAdminGeneratorHelper::getPath()

} // dinMenuItemAdminGeneratorHelper

//EOF