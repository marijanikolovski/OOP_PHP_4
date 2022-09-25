<?php

abstract class Room {
    public $roomNumber;
    public $bedNumber;
    public $hasBathroom;
    public $hasBalcony;
}

interface RoomFactory {
    public function makeRoom($rooNumber, $hasBatroom, $hasBalcony);
}

class Room1 extends Room {
    public function __construct($rooNumber,  $hasBatroom, $hasBalcony)
    {
        $this->roomNumber = $rooNumber;
        $this->bedNumber = 1;
        $this->hasBathroom = $hasBatroom;
        $this->hasBalcony = $hasBalcony;
    }
}

class Room2 extends Room {
    public function __construct($rooNumber, $hasBatroom, $hasBalcony)
    {
        $this->roomNumber = $rooNumber;
        $this->bedNumber = 2;
        $this->hasBathroom = $hasBatroom;
        $this->hasBalcony = $hasBalcony;
    }
}

class Room3 extends Room {
    public function __construct($rooNumber, $hasBatroom, $hasBalcony)
    {
        $this->roomNumber = $rooNumber;
        $this->bedNumber = 3;
        $this->hasBathroom = $hasBatroom;
        $this->hasBalcony = $hasBalcony;
    }
}

class Room1Factory implements  RoomFactory {
    public function makeRoom($rooNumber, $hasBatroom, $hasBalcony) {
        return new Room1($rooNumber, $hasBatroom, $hasBalcony); 
    }
}

class Room2Factory implements RoomFactory {
    public function makeRoom($rooNumber, $hasBatroom, $hasBalcony) {
        return new Room2($rooNumber, $hasBatroom, $hasBalcony); 
    }
}

class Room3Factory implements RoomFactory{
    public function makeRoom($rooNumber, $hasBatroom, $hasBalcony) {
        return new Room3($rooNumber, $hasBatroom, $hasBalcony); 
    }
}

$roomFactory1 = new Room1Factory();
$room1 = $roomFactory1->makeRoom('125', true, false);

$roomFactory2 = new Room1Factory();
$room2 = $roomFactory2->makeRoom('126', true, true);

$roomFactory3 = new Room1Factory();
$room3 = $roomFactory3->makeRoom('127', true, true);

echo '<pre>';
var_dump($room1);
var_dump($room2);
var_dump($room3);