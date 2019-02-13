<?php
header('Content-type:text/html;charset=utf-8');
include("weather.php");
$appkey="bff4a7110f51a1c57a69cd5e2d4e88e7";
$weather=new weather($appkey);
$cityWeatherResult = $weather->getWeather('苏州');
if($cityWeatherResult['error_code'] == 0){    //以下可根据实际业务需求，自行改写
    //////////////////////////////////////////////////////////////////////
    $data = $cityWeatherResult['result'];
    echo "=======当前天气实况=======<br>";
    echo "温度：".$data['sk']['temp']."    ";
    echo "风向：".$data['sk']['wind_direction']."    （".$data['sk']['wind_strength']."）";
    echo "湿度：".$data['sk']['humidity']."    ";
    echo "<br><br>";
 
    echo "=======未来几天天气预报=======<br>";
    foreach($data['future'] as $wkey =>$f){
        echo "日期:".$f['date']." ".$f['week']." ".$f['weather']." ".$f['temperature']."<br>";
    }
    echo "<br><br>";
 
    echo "=======相关天气指数=======<br>";
    echo "穿衣指数：".$data['today']['dressing_index']." , ".$data['today']['dressing_advice']."<br>";
    echo "紫外线强度：".$data['today']['uv_index']."<br>";
    echo "舒适指数：".$data['today']['comfort_index']."<br>";
    echo "洗车指数：".$data['today']['wash_index'];
    echo "<br><br>";
 
}else{
    echo $cityWeatherResult['error_code'].":".$cityWeatherResult['reason'];
}
?>