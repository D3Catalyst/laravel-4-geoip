<?php namespace D3Catalyst\GeoIP;

/**
*  Contains all the method to retrieve data from ip-api.com.
*
*  This contains the geoip data as well all the marshalling mechanism from
*  the web service.
*
*  @author Darwin Biler <buonzz@gmail.com>
*
*  Edited for me
*  @author Ricardo Madrigal <soporte@d3catalyst.com>
*/
class GeoIP{


  /**  @var mixed $geoip_data  contains the JSON object retrieved from the API */
  private $geoip_data = NULL;

  /**  @var string $ip contains the IP of the current visitor */
  private $ip = NULL;


  /**
  * constructor which initialiazes various things.
  *
  * detects if the REMOTE_ADDR is present (usually not, when running in cli or phpunit)
  * if present use that one.
  *
  * @return void
  */
  public function __construct(){
    $ip = $this->getClientIp();
    if($ip!==false)
      $this->ip = $ip;
  }

  /**
  * allows the user to set the IP to be process instead of retrieving it from server.
  *
  * @return void
  */
  public function setIP($ip){
    $this->ip = $ip;
  }

  /**
  * get the descriptive name of the country.
  *
  * @return string
  */
  public function getCountry(){
			return $this->getItem('country');
   }

  /**
  * get the 2-letter code  of the country.
  *
  * @return string
  */
  public function getCountryCode(){
      return $this->getItem('countryCode');
   }

  /**
  * get the region code.
  *
  * @return string
  */
  public function getRegionCode(){
      return $this->getItem('region');
   }

  /**
  * get the descriptive name of the region.
  *
  * @return string
  */
   public function getRegion(){
       return $this->getItem('regionName');
   }

  /**
  * get the descriptive name of the City.
  *
  * @return string
  */
  public function getCity(){
       return $this->getItem('city');
   }

  /**
  * get the zip code.
  *
  * @return string
  */
  public function getZipCode(){
       return $this->getItem('zip');
   }

  /**
  * get the latitude of the location.
  *
  * @return string
  */
  public function getLatitude(){
       return $this->getItem('lat');
   }

  /**
  * get the longitude of the location.
  *
  * @return string
  */
  public function getLongitude(){
      return $this->getItem('lon');
   }

  /**
  * get the timezone.
  *
  * @return string
  */
  public function getTimezone(){
     return $this->getItem('timezone');
   }


  /**
  * get the ISP.
  *
  * @return string
  */
  public function getIsp(){
      return $this->getItem('isp');
   }

  /**
  * generic property retriever.
  *
  * @param string $name get cached item
  * @return string
  */
  private function getItem($name){

        if($this->geoip_data == NULL)
          $this->retrievefromCache();

		if(isset($this->geoip_data->$name)){
			return $this->geoip_data->$name;
		}
        return "";
   }

   /**
  * Get all geo information
  *
  * @return string
  */
  public function getAll(){

        if($this->geoip_data == NULL)
          $this->retrievefromCache();

        return $this->geoip_data;
   }

  /**
  * check if the Cache class exists and use caching mechanism if there is, otherwise just call the API directly.
  *
  * @return void
  */
  private function retrievefromCache(){

      if (class_exists('\\Cache'))
      {

        $cache_key = 'l4-geoip-'. $this->ip;

        if (\Cache::has($cache_key))
             $this->geoip_data = \Cache::get($cache_key);
          else
          {
              $this->geoip_data = $this->resolve($this->ip);
              \Cache::put($cache_key, $this->geoip_data , 60*60);
          }
      }
      else
           $this->geoip_data = $this->resolve($this->ip);
   }


  /**
  * call the ip-api.com for data, retrieve it as JSON and convert it to stdclass.
  *
  * @param string $ip ip to check
  * @return void
  */
   function resolve($ip){

      $url      = 'http://ip-api.com/json/'.$ip;
      $timeout  = 30; // Timeout

      $ch = curl_init($url);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

      $file_contents = curl_exec($ch);
      curl_close($ch);

      $data = json_decode($file_contents);

      if($data == NULL)
          throw new \Exception("Problems in retrieving data from http://ip-api.com");

      return $data;
    }

    /**
    * Get real IP of visitor
    *
    * @return String Visitor IP
    */
    private function getClientIp() {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']) && !empty($_SERVER['HTTP_X_FORWARDED']))
            return $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']) && !empty($_SERVER['HTTP_FORWARDED_FOR']))
            return $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']) && !empty($_SERVER['HTTP_FORWARDED']))
            return $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']))
            return $_SERVER['REMOTE_ADDR'];
        else
            return false;
    }

}