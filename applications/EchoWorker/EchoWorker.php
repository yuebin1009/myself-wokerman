<?php 

class EchoWorker extends Man\Core\SocketWorker
{
    /**
     * 确定包是否完整 return 0:完整 return X:还有X字节没有接收完
     */
    /*
    public function dealInput($buffer)
    {
        var_dump($buffer);
        echo 'here'."\n";
        // 如果最后一个字符是\n代表数据读取完整，返回0
        if($buffer[strlen($buffer)-1] === "\n")
        {
            echo '1'."\n";
            return 0;
        }

        // 说明还有请求数据没收到，但是由于不知道还有多少数据没收到，所以只能返回1，因为有可能下一个字符就是\n
        return 1;
    }
     */
    /*    
    public function dealInput($buffer){

        $recvLen = strlen($buffer);
        if($recvLen < 8){
        
            return 8 - $recvLen;
        }

        $unpackData = unpack('NtotalLen', $buffer);
        $totalLen = $unpackData['totalLen'];
        return $totalLen - $recvLen;

    }
    */

    public function dealInput($buffer){

        $recvLen = strlen($buffer);
        var_dump($buffer);
        echo "\n";
        if($recvLen < 8){
        
            return 8 - $recvLen;
        }

        $jsonStr = substr($buffer,0,8);
        $totalLen = base_convert($jsonStr,10,10); 
        return $totalLen - $recvLen;
    }
    /**
     * 处理业务，当客户端数据接收完毕后触发（这里只是将客户端发来的字符串直接会写到客户端）
     */
    public function dealProcess($buffer)
    {
        echo 2;
        var_dump($buffer);
        return $this->sendToClient($buffer);    

    }

    /**
     * 重写钩子函数 onStart
     */
    public function onStart(){
    
        return '初始化连接';
    }

}
