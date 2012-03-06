<?php
/**
 *
 * the interface every bserver Object Need Implements
 * @author iann
 *
 */
namespace BlueSeed\Observer;
interface Observer
{
    public function update(Observable $o);
}
?>