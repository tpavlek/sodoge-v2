<?php

namespace Depotwarehouse\SoDoge\Model\ValueObjects;

use Depotwarehouse\Blumba\Domain\ValueObject;
use Depotwarehouse\Blumba\Domain\ValueObjectInterface;

class Phrase extends ValueObject
{

    protected $text;
    protected $x;
    protected $y;
    protected $color;
    protected $font_size;

    public function __construct($text, $x, $y, $color, $font_size)
    {
        $this->text = $text;
        $this->x = $x;
        $this->y = $y;
        $this->color = $color;
        $this->font_size = $font_size;
    }

    protected function equalsSelf(ValueObjectInterface $otherObject)
    {
        /** @var self $otherObject */
        // TODO this ought to compare the other attributes as well
        return $this->toString() === $otherObject->toString();
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return mixed
     */
    public function getFontSize()
    {
        return $this->font_size;
    }

    public function toString()
    {
        return (string)$this->text;
    }
}
