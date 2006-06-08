<?php

require_once '../dibi/dibi.php';



/**
 * Pseudotype for UNIX timestamp representation
 */
class TDateTime implements IDibiVariable
{
    /**
     * Unix timestamp
     * @var int
     */
    protected $time;



    public function __construct($time = NULL)
    {
        if ($time === NULL)
            $this->time = time(); // current time

        elseif (is_string($time))
            $this->time = strtotime($time); // try convert to timestamp

        else
            $this->time = (int) $time;
    }



    /**
     * Format for SQL
     *
     * @param  object  destination DibiDriver
     * @param  string  optional modifier
     * @return string
     */
    public function toSQL($driver, $modifier = NULL)
    {
        return date(
            $driver->formats['datetime'],  // format according to driver's spec.
            $this->time
        );
    }



}



// connects to mysqli
dibi::connect(array(
    'driver'   => 'mysqli',
    'host'     => 'localhost',
    'username' => 'root',
    'password' => 'xxx',  // change to real password!
    'charset'  => 'utf8',
));



// generate and dump SQL
dibi::test("
INSERT INTO [test]", array(
    'A' => 12,
    'B' => NULL,
    'C' => new TDateTime(31542),  // using out class
    'D' => 'any string',
));


?>