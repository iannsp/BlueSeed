<?php
/**
 *
 * the interface every observavle object need implements
 * @author iann
 *
 */
namespace BlueSeed\Observer;
interface Observable
{
    public function attachObserver(Observer $o);
    public function detachObserver(Observer $o);
    public function notifyObservers();
}
