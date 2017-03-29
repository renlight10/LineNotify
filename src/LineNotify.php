<?php
namespace renlight10\LineNotify;

class LineNotify
{
    protected $token;
    protected $message;
    protected $imageThumbnail;
    protected $imageFullsize;
    protected $stickerPackageId;
    protected $stickerId;
    public function __construct($token)
    {
        if (!isset($token)) {
            throw new Exception("token couldn't be empty!");
        } else {
                $this->token=$token;
        }
    }
    public function __call($method, $arg)
    {
        $allowmethod = substr($method, 0, 3);
        if ($allowmethod==="SET") {
            $property = substr($method, 3);
            if (property_exists($this, $property)) {
                $this->$property = $arg[0];
                return $this;
            } else {
                throw new Exception("$property property not found!");
                return $this;
            }
        } else {
            throw new Exception("call to undefined method $method!");
            return $this;
        }
    }
    public function sendIt()
    {
        //memproses
        $url="https://notify-api.line.me/api/notify";
            $ch = curl_init($url);
            $header = array("Content-Type:application/x-www-form-urlencoded","Authorization:Bearer $this->token");
            $body = http_build_query(get_object_vars($this));
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            //mengolah
            list($response_header, $response_body) = explode("\r\n\r\n", $result, 2);
            unset($result);
            $a_header=explode("\n", $response_header);
            $_header=array();
        foreach ($a_header as $key => $value) {
            $data=explode(":", $value);
            $_header[$data[0]]=$data[1];
        }
            unset($data);
            unset($a_header);
            $_body=json_decode($response_body, true);
            //tampilkan hasil
            $hasil=["header"=>["Limit"=>(int)$_header["X-RateLimit-Limit"],"ImageLimit"=>(int)$_header["X-RateLimit-ImageLimit"],"Remaining"=>(int)$_header["X-RateLimit-Remaining"],"ImageRemaining"=>(int)$_header["X-RateLimit-ImageRemaining"],"Reset"=>(int)$_header["X-RateLimit-Reset"]],"body"=>["status"=>(int)$_body["status"],"message"=>$_body["message"]]];
            return json_encode($hasil);
    }
}
