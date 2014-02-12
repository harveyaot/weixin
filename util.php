<?php
class util
{
    //回复文字消息
    public function makeText($text='',$postObj)
    {
        $CreateTime = time();
        $FuncFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>  
            <ToUserName><![CDATA[{$postObj->FromUserName}]]></ToUserName>  
            <FromUserName><![CDATA[{$postObj->ToUserName}]]></FromUserName>  
            <CreateTime>{$CreateTime}</CreateTime>  
            <MsgType><![CDATA[text]]></MsgType>  
            <Content><![CDATA[%s]]></Content>  
            <FuncFlag>%s</FuncFlag>  
            </xml>";
        return sprintf($textTpl,$text,$FuncFlag);
    }

    //根据数组参数回复图文消息  
    public function makeNews($newsData=array(),$postObj)
    {
        $CreateTime = time();
        $FuncFlag = $this->setFlag ? 1 : 0;
        $newTplHeader = "<xml>  
            <ToUserName><![CDATA[{$postObj->FromUserName}]]></ToUserName>  
            <FromUserName><![CDATA[{$postObj->ToUserName}]]></FromUserName>  
            <CreateTime>{$CreateTime}</CreateTime>  
            <MsgType><![CDATA[news]]></MsgType>  
            <Content><![CDATA[%s]]></Content>  
            <ArticleCount>%s</ArticleCount><Articles>";
        $newTplItem = "<item>  
            <Title><![CDATA[%s]]></Title>  
            <Description><![CDATA[%s]]></Description>  
            <PicUrl><![CDATA[%s]]></PicUrl>  
            <Url><![CDATA[%s]]></Url>  
            </item>";
        $newTplFoot = "</Articles>  
            <FuncFlag>%s</FuncFlag>  
            </xml>";
        $Content = '';
        $itemsCount = count($newsData['items']);
        $itemsCount = $itemsCount < 10 ? $itemsCount : 10;//微信公众平台图文回复的消息一次最多10条  
        if ($itemsCount) {
            foreach ($newsData['items'] as $key => $item) {
                if ($key<=9) {
                    $Content .= sprintf($newTplItem,$item['title'],$item['description'],$item['picurl'],$item['url']);
                }
            }
        }
        $header = sprintf($newTplHeader,$newsData['content'],$itemsCount);
        $footer = sprintf($newTplFoot,$FuncFlag);
        return $header . $Content . $footer;
    }
}
?>
