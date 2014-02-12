<?php
define('AK','F0f0fdc4d720ca58e883ae67e208eaf3');        
define('URL', 'http://api.map.baidu.com/place/v2/search');  //API 请求地址  
require_once('./util.php');
class lbs
{
     public function map($lox,$loy,$key){  
        //需要PHP 5 以上以及安装curl扩展  
        $params = array('ak'=>AK,'output'=>'json','query'=>$key,'page_size'=>'10','page_num'=>'0','scope'=>'2','location'=>$lox.','.$loy,'radius'=>'5000');  
        $queryString = '';  //请求的URL参数  
  
        while (list($key, $val) = each($params))  
        {  
            $queryString .=('&'.$key.'='.urlencode($val));  
        }  
        $url = URL.'?'.$queryString;  
          
        $curl = curl_init();  
        curl_setopt($curl, CURLOPT_URL, $url);// 设置你要访问的URL  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。  
        curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');  
        $data = json_decode(curl_exec($curl), true);// 运行cURL，请求API  
        curl_close($curl);// 关闭URL请求  
  
        //var_dump($data);  
        //echo $data['total']."<br>";   
        //echo $data['results'][0]['name'];   
         //$this->makeText("123");  
        $record=array();   
        $record[0]=array(   
                    'title' =>'周边5公里内酒店信息',  
                    'description' =>'',  
                    'picurl' => '',  
                'url' =>''  
            );    
            //$this->makeText(count($data['results']));   
        if(count($data['results'])==0)  
        {  
            $reply = $this->makeText('很抱歉，周边5公里内未找到**酒店。');  
            return $reply;  
            exit;   
        }                
        for($i=1;$i<=count($data['results']);$i++)  
        {  
            $distance = sprintf("%01.1f",($data['results'][$i-1]['detail_info']['distance']/1000));  
            $title = $i."、 ".$data['results'][$i-1]['name']." ￥".intval($data['results'][$i-1]['detail_info']['price'])."  ".$distance."公里 ".$data['results'][$i-1]['telephone'];  
            $description = '';  
            $picurl = '';  
            $url = '';  
            $record[$i]=array(   
                    'title' =>$title,  
              'description' =>$description,  
                   'picurl' => $picurl,  
                      'url' =>$url  
                    );  
  
        }   
       $results['items'] = $record;             
       return $results;  
    }  
    

    public function reply($data)  
    {  
        if ($this->debug) {  
                    $this->write_log($data);  
        }  
        echo $data;  
    }  


}//end of class
?>
