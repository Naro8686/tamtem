<?php

namespace App\Classes\YandexMoney;

use App\Classes\YandexMoney\interfaces\IDispositionRequestProvider;
use App\Classes\YandexMoney\interfaces\IXMLTransformable;
use Ramsey\Uuid\Uuid;

class PKCS7RequestProvider implements IDispositionRequestProvider
{
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function processRequest($handler)
    {
        if (($request = $this->verifyData(file_get_contents("php://input"))) == null) {
            /**
             * @var IXMLTransformable $params
             */
            $params = call_user_func($handler, $request);
            header("HTTP/1.0 200");
            header("Content-Type: application/pkcs7-mime");
            echo $this->signData($params->toXml());
            exit;
        }
    }

    public function sendRequest($dispositionMethod, IXMLTransformable $params)
    {
        // file_put_contents("c:/temp/req.xml", $params->toXml());
        // dd($params->toXml());
        $post_data = $this->signData($params->toXml());
    //    file_put_contents("c:/temp/req_signed.txt",  $post_data);
      //  dd($post_data);
//$verbosePath = 'c:\temp\verbose.txt';
//dd($this->settings->cert);
        $curl   = curl_init();
        $params = array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER     => array('Content-type: application/pkcs7-mime'),
            CURLOPT_URL            => rtrim( $this->settings->host, '/') .
                '/webservice/deposition/api/' . trim($dispositionMethod, '/'),
            CURLOPT_POST           => true,
            CURLOPT_HEADER           => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_SSLCERT        => $this->settings->cert,
            CURLOPT_SSLKEY         => $this->settings->privateKey,
            CURLOPT_SSLCERTPASSWD  => $this->settings->certPassword,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_VERBOSE        => 0,
            CURLOPT_POSTFIELDS     => $post_data,
        );

        curl_setopt_array($curl, $params);
//curl_setopt($curl, CURLOPT_VERBOSE, true);
//curl_setopt($curl, CURLOPT_STDERR,$f = fopen($verbosePath, "w+"));
        $result = null;
        try {
            $result = curl_exec($curl);
//dd($result);
// dd(curl_getinfo($curl) );
            if (!$result) {
                return curl_error($curl);
               // trigger_error(curl_error($curl));
            }
            curl_close($curl);
            //fclose($f);
        } catch (\HttpException $exception) {
            return $exception;
        }
        //dd($post_data , $result);
        return $this->verifyData($result);
    }

    private function signData($data)
    { 
        $descriptorSpec      = array(
            0 => array( "pipe", "r" ),
            1 => array( "pipe", "w" ),
        );
        $descriptorSpec[ 2 ] = $descriptorSpec[ 1 ];
        try {
            $opensslCommand = 'openssl smime -sign -signer ' . $this->settings->cert .
                ' -inkey ' . $this->settings->privateKey .
                ' -nochain -nocerts -outform PEM -nodetach -passin pass:' . $this->settings->certPassword;
//dd($opensslCommand);
            $process = proc_open($opensslCommand, $descriptorSpec, $pipes);

            if (is_resource($process)) {
                fwrite($pipes[0], $data);
                fclose($pipes[0]);
                $signedData = stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                $resCode = proc_close($process);
    //dd($resCode);            
                if ($resCode != 0) {
                    $errorMsg = 'OpenSSL call failed:' . $resCode . '\n' . $signedData;
                    throw new \Exception($errorMsg);
                }
                return $signedData;
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function verifyData($data)
    { //dd($data);
        $descriptorSpec = array(
            0 => array( "pipe", "r" ),
            1 => array( "pipe", "w" ),
            2 => array( "pipe", "w" )
        );
        $verifyCommand  = 'openssl smime -verify -inform PEM -nointern' .
            ' -certfile ' . $this->settings->yaCert .
            ' -CAfile ' . $this->settings->yaCert;

        $process = proc_open($verifyCommand, $descriptorSpec, $pipes);

        if (is_resource($process)) {
            fwrite($pipes[0], $data);
            fclose($pipes[0]);
            $content = stream_get_contents($pipes[1]);
//dd($content );
            fclose($pipes[1]);
            $resCode = proc_close($process);

            if ($resCode != 0) {
                return null;
            } else {
                $xml   = simplexml_load_string($content);
                $array = json_decode(json_encode($xml), true);
                return $array["@attributes"];
            }
        }
        return null;
    }
}