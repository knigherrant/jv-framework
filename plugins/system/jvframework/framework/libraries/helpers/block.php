<?php
/**
# JV Framework
# @version		1.5.x
# ------------------------------------------------------------------------
# author    PHPKungfu Solutions Co
# copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
# Websites: http://www.phpkungfu.club
# Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
JVFrameworkLoader::import ( 'helpers.template' );

class JVFrameworkHelperBlock extends JVFrameworkHelperTemplate {
    protected $_name    = 'block';
    protected static $_block = array();

    public function render($block, $positions = null) {
        $options = array();
        if (strpos($block, '::')){
            list ( $block, $options ) = explode ( '::', $block );
            $options = json_decode($options, true);
        }

        if (strpos($block, '.')){
            list ( $block, $options['style'] ) = explode ( '.', $block );
        }

        if (isset ( $this->_unloads [$block] )) {
            return false;
        }

        // Merge Block Options
        foreach ($this['option']->get('block.'.$block, array()) as $key => $val){
            if(isset($options[$key]) && is_string($options[$key])){
                if($val)
                    $options[$key] .= ' '.$val;
            }else{
                $options[$key] = $val;
            }
        }

        $block = isset ( $this->_alias [$block] )   ? $this->_alias [$block]   : $block;

        if (isset ( $this->_unloads [$block] )) {
            return false;
        }

        $positions = is_null($positions) ? $this->getPosition($block) : $positions;

        if(!isset($options['grid'])){
            $options['grid'] = '';
        }

        return $this ['template']->render ( 'block', compact('block', 'positions', 'options') );
    }

    public function count($block) {
        $positions = $this->getPosition($block);

        return $this['position']->count( implode(' or ', $positions) );

    }

    protected function getPosition($position){
        if(!isset(self::$_block[$position])){
            self::$_block[$position] = $this['manifest']->getPositions($position);
        }

        return self::$_block[$position];
    }

    protected function calcGrid(&$grid, &$count){
        if(!$grid){
            $grid = array();
            for ($i = 0; $i < $count; $i++ ){

                if($count == 5 && $i == 4){
                    $grid[$i] = '4';
                }else {
                    $grid[$i] = round(12/$count);
                }
            }
        }else{
            $grid  = json_decode($grid);
            $cgrid = count($grid);

            if($cgrid > $count){
                $newgrid = array();

                for ($i = 0; $i < $count; $i++ ){
                    $newgrid[$i] = $grid[$i];
                }

                if(array_sum($newgrid) < 12){
                    $newgrid[count($newgrid)-1] = 0;
                    $newgrid[count($newgrid)-1] = 12 - array_sum($newgrid);
                }

                $grid = $newgrid;

            }else{
                $count = $cgrid;
            }
        }
    }
}
?>