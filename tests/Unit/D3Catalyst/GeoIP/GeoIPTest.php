<?php 

/**
*  Corresponding Class to test GeoIP class.
*
*
*  @author Ricardo Madrigal <soporte@d3catalyst.com>
*/
class GeoIPTest extends PHPUnit_Framework_TestCase{
	
  /**
  * Just check if the YourClass has no syntax error. 
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
  public function testIsThereAnySyntaxError(){
  	$var = new D3Catalyst\GeoIP\GeoIP;
  	$this->assertTrue(is_object($var));
  	unset($var);
  }
  
  
  /**
  * Just check if the GeoIP can retrieve Country info.
  *
  * I hardcoded here one of my dynamic ip and see if it will return my country name
  *
  */
  public function testgetCountry(){
  	$var = new D3Catalyst\GeoIP\GeoIP;
    $var->setIP('187.247.1.177');
  	$this->assertTrue($var->getCountry() == 'Mexico');
  	unset($var);
  }
  
}