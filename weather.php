<?php
class weather{
    private $appkey = false; //����ľۺ�����Ԥ��APPKEY
 
    private $cityUrl = 'http://v.juhe.cn/weather/citys'; //�����б�API URL
 
    private $weatherUrl = 'http://v.juhe.cn/weather/index'; //���ݳ�����������API URL
 
    private $weatherIPUrl = 'http://v.juhe.cn/weather/ip'; //����IP��ַ��������API URL
 
    private $weatherGeoUrl = 'http://v.juhe.cn/weather/geo'; //����GPS�����ȡ����API URL
 
    private $forecast3hUrl = 'http://v.juhe.cn/weather/forecast3h'; //��ȡ��������3СʱԤ��API URL
 
    public function __construct($appkey){
        $this->appkey = $appkey;
    }
 
    /**
     * ��ȡ����Ԥ��֧�ֳ����б�
     * @return array
     */
    public function getCitys(){
        $params = 'key='.$this->appkey;
        $content = $this->juhecurl($this->cityUrl,$params);
        return $this->_returnArray($content);
    }
 
    /**
     * ���ݳ�������/ID��ȡ��ϸ����Ԥ��
     * @param string $city [��������/ID]
     * @return array
     */
    public function getWeather($city){
        $paramsArray = array(
            'key'   => $this->appkey,
            'cityname'  => $city,
            'format'    => 2
        );
        $params = http_build_query($paramsArray);
        $content = $this->juhecurl($this->weatherUrl,$params);
        return $this->_returnArray($content);
    }
 
    /**
     * ����IP��ַ��ȡ��������Ԥ��
     * @param string $ip [IP��ַ]
     * @return array
     */
    public function getWeatherByIP($ip){
         $paramsArray = array(
            'key'   => $this->appkey,
            'ip'  => $ip,
            'format'    => 2
        );
        $params = http_build_query($paramsArray);
        $content = $this->juhecurl($this->weatherIPUrl,$params);
        return $this->_returnArray($content);
    }
 
    /**
     * ����GPS�����ȡ���ص�����Ԥ��
     * @param  string $lon [����]
     * @param  string $lat [γ��]
     * @return array
     */
    public function getWeatherByGeo($lon,$lat){
        $paramsArray = array(
            'key'   => $this->appkey,
            'lon'  => $lon,
            'lat'   => $lat,
            'format'    => 2
        );
        $params = http_build_query($paramsArray);
        $content = $this->juhecurl($this->weatherGeoUrl,$params);
        return $this->_returnArray($content);
    }
 
    /**
     * ��ȡ������СʱԤ��
     * @param  string $city [��������]
     * @return array
     */
    public function getForecast($city){
        $paramsArray = array(
            'key'   => $this->appkey,
            'cityname'  => $city,
            'format'    => 2
        );
        $params = http_build_query($paramsArray);
        $content = $this->juhecurl($this->forecast3hUrl,$params);
        return $this->_returnArray($content);
    }
 
    /**
     * ��JSON����תΪ���ݣ�������
     * @param string $content [����]
     * @return array
     */
    public function _returnArray($content){
        return json_decode($content,true);
    }
 
    /**
     * ����ӿڷ�������
     * @param  string $url [�����URL��ַ]
     * @param  string $params [����Ĳ���]
     * @param  int $ipost [�Ƿ����POST��ʽ]
     * @return  string
     */
    public function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
 
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }
 
}