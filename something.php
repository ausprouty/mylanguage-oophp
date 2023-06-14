<?php
class MyClass
{
    public $publicProperty = 'Public';
    private $privateProperty = 'Private';
    protected $protectedProperty = 'Protected';

    public function getPublicProperties(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        $result = [];

        foreach ($properties as $property) {
            $result[$property->getName()] = $property->getValue($this);
        }

        return $result;
    }
}

$obj = new MyClass();
$publicProperties = $obj->getPublicProperties();

print_r($publicProperties);
