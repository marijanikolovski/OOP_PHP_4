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

class Hotel {
    private static $instance;
    public $rooms = [];
    public $waitingList = [];

    static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Hotel();
        }
        return self::$instance;
    }

    public function setRoom(Room $room) {
        $roomClass = get_class($room);
        $this->rooms[$roomClass][] = $room;
    }

    public function getRoom() {
        return $this->rooms;
    }

    public function freeRoom($type) {
        return count($this->rooms[$type]);
    }

    public function checkRoom(Room $room, User $user)
    {
        $roomClass = get_class($room);
        if (count($this->rooms[$roomClass]) === 0) {
            echo 'Out of stock';
            $this->waitingList[] = $user;
            echo $user->firstName . ' has been added to the waiting list';
        }
        array_pop($this->rooms[$roomClass]);
        echo $user->firstName . ' was given a room';
    }

    public function outRoom(Room $room) {
        $roomClass = get_class($room);
        $this->rooms[$roomClass][] = $room;
        if (count($this->rooms[$roomClass]) > 0) {
            if(count($this->waitingList) > 0) {
                echo 'Room is free';
                $user = array_pop($this->waitingList);
                $this->checkRoom($room, $user);
            }
        }
    }
}

class User {
    public $firstName;
    public $lastName;
    public $jmbg;

    public function __construct($firstName, $lastName, $jmbg)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->jmbg = $jmbg;
    }
}


$roomFactory1 = new Room1Factory();
$room1 = $roomFactory1->makeRoom('125', true, false);

$roomFactory2 = new Room2Factory();
$room2 = $roomFactory2->makeRoom('126', true, true);

$roomFactory3 = new Room3Factory();
$room3 = $roomFactory3->makeRoom('127', true, true);

$hotel = Hotel::getInstance();
$hotel->setRoom($room1);
$hotel->getRoom();

$hotel->setRoom($room2);
$hotel->getRoom();

$hotel->setRoom($room3);
$hotel->getRoom();

$milan = new User('Milan', 'Milovanovic', '12367');
$vukasin = new User('Vukasin', 'Milovanovic', '12367');
$jovan = new User('Jovan', 'Jovanovic', '1258');
$stribor= new User('Stribor', 'Jovanovic', '33258');

$hotel->checkRoom($room1, $milan);
$hotel->checkRoom($room2, $vukasin);
$hotel->checkRoom($room3, $jovan);
$hotel->checkRoom($room1, $stribor);

echo '<pre>';
var_dump($hotel);

echo $hotel->freeRoom(Room1::class);
echo $hotel->freeRoom(Room2::class);
echo $hotel->freeRoom(Room3::class);