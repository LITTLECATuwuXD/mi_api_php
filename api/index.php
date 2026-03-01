<?php
require 'core-master/flight/Flight.php';

Flight::route('/', function () {
    echo "Hola mundo";
});

Flight::start();
