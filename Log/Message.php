<?php
/**
 * @author iann
 * this class format a Message to Use in Writers
 *
 */
namespace BlueSeed\Log;
abstract class Message
{
    /**
     *
     * make the properties in a string when use this class in echo
     */
    public function __toString()
    {
        $props      = Array();
        $properties = $this->getProperties();
        foreach ($properties as  $property) {
            $props .= array_push($props, "{$property->getName()}:{$property->getValue()}");
        }
        return explode(',', $props);
    }
    /**
     *
     * Explicit request of all data into String
     */
    public function toString()
    {
        return $this->__toString();
    }

    /**
     *
     * Return all Properties in a Json type
     */
    public function toJson()
    {
        return json_encode($this);
    }

    /**
     *
     * return Properties Objects with all private property(log value)
     */
    protected function getProperties()
    {
        $class = New \ReflectionClass($this);
        return $class->getProperties(\ReflectionProperty::IS_PRIVATE);
    }
}
