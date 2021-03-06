<?PHP
/**
 * @author zemzheng@gmail.com
 * @description
 * @see https://github.com/zemzheng/WeChatPHP-SDK
 * @see http://admin.wechat.com/wiki
 * @see http://mp.weixin.qq.com/wiki
 */
class WeChatServer{
    private $_token;
    /**
     * ****** hooks list ******
     * receiveAllStart
     * receiveMsg::text
     * receiveMsg::location
     * receiveMsg::image
     * receiveMsg::video
     * receiveMsg::link
     * receiveMsg::voice
     * receiveEvent::subscribe
     * receiveEvent::unsubscribe
     * receiveEvent::scan
     * receiveEvent::location
     * receiveEvent::click
     * receiveEvent::masssendjobfinish
     * receiveAllEnd
     * accessCheckSuccess
     * 404
     */
    private $_hooks;

    public static $ERRCODE_MAP;

    public function __construct( $token, $hooks  = array() ){
        $this->_token = $token;
        $this->_hooks = $hooks;
        $this->accessDataPush();
    }

    private function _activeHook( $type ){
        if( 
            !isset( $this->_hooks[$type] )
            || !is_callable( $this->_hooks[$type] )
        ) return null;
        $argvs = func_get_args();
        array_shift( $argvs );
        return call_user_func_array(
            $this->_hooks[ $type ], $argvs
        );
    }
    private function _checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	

        $token = $this->_token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort( $tmpArr, SORT_STRING );
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        return $tmpStr == $signature;
    }

    private function _handlePostObj( $postObj ){
        $MsgType = strtolower( (string)$postObj->MsgType );
        $result = array(
            'from'  => self::$_from_id = (string) htmlspecialchars( $postObj->FromUserName ),
            'to'    => self::$_my_id   = (string) htmlspecialchars( $postObj->ToUserName ),
            'time'  => (int)    $postObj->CreateTime,
            'type'  => (string) $MsgType
        );

        if( property_exists($postObj, 'MsgId') ){
            $result['id'] = $postObj->MsgId;
        }

        switch( $result['type'] ){
            case 'text':
                $result['content'] = (string) $postObj->Content; // Content ????????????
                break;

            case 'location':
                $result['X'] = (float) $postObj->Location_X; // Location_X ??????????????????
                $result['Y'] = (float) $postObj->Location_Y; // Location_Y ??????????????????
                $result['S'] = (float) $postObj->Scale;      // Scale ??????????????????
                $result['I'] = (string) $postObj->Label;     // Label ??????????????????
                break;

            case 'image':
                $result['url'] = (string) $postObj->PicUrl;  // PicUrl ?????????????????????????????????HTTP GET??????
                $result['mid'] = (string) $postObj->MediaId; // MediaId ??????????????????id?????????????????????????????????????????????????????????
                break;

            case 'video':
                $result['mid']      = (string) $postObj->MediaId;      // MediaId ??????????????????id?????????????????????????????????????????????????????????
                $result['thumbmid'] = (string) $postObj->ThumbMediaId; // ThumbMediaId ??????????????????????????????id?????????????????????????????????????????????????????????
                break;

            case 'link':
                $result['title'] = (string) $postObj->Title;       // ????????????
                $result['desc']  = (string) $postObj->Description; // ????????????
                $result['url']   = (string) $postObj->Url;         // ????????????
                break;

            case 'voice':
                $result['mid']    = (string) $postObj->MediaId;     // ??????????????????id?????????????????????????????????????????????????????????
                $result['format'] = (string) $postObj->Format;      // ???????????????amr
                if( property_exists( $postObj, Recognition ) ){
                    $result['txt']    = (string) $postObj->Recognition; // ?????????????????????UTF8??????
                }
                break;

            case 'event':
                $result['event'] = strtolower((string) $postObj->Event);    // ???????????????subscribe(??????)???unsubscribe(????????????)???CLICK(???????????????????????????
                switch( $result['event'] ){

                    // case 'unsubscribe': // ????????????
                    case 'subscribe': // ?????? 
                    case 'scan': // ???????????????
                        if( property_exists( $postObj, EventKey ) ){
                            // ??????????????????????????????
                            $result['key'] = str_replace(
                                'qrscene_', '', (string) $postObj->EventKey 
                            ); // ??????KEY??????qrscene_??????????????????????????????????????????
                            $result['ticket'] = (string) $postObj->Ticket;
                        }
                        break;

                    case 'location': // ????????????????????????
                        $result['la'] = (string) $postObj->Latitude;  // ??????????????????
                        $result['lo'] = (string) $postObj->Longitude; // ??????????????????
                        $result['p']  = (string) $postObj->Precision; // ??????????????????
                        break;

                    case 'click': // ?????????????????????
                        $result['key']   = (string) $postObj->EventKey; // ??????KEY?????????????????????????????????KEY?????????
                        break;

                    case "masssendjobfinish": // ??????????????????

                        $result['id']     = (string) $postObj->MsgID;                   // ???????????????ID
                        $result['status'] = (bool) 'send success' === $postObj->Status; // ????????????
                        $result['msg']    = (string) self::$ERRCODE_MAP[ $postObj->Status ];

                        // TotalCount >= FilterCount
                        // FilterCount = SentCount + ErrorCount
                        $result['total'] = (string) $postObj->TotalCount;     // group_id?????????????????????openid_list???????????????
                        $result['fact']  = (string) $postObj->FilterCount;    // ??????????????????????????????????????????????????????
                        $result['hit']   = (string) $postObj->SentCount;      // ????????????????????????
                        $result['miss']  = (string) $postObj->ErrorCount;     // ????????????????????????
                        break;
                }
        }

        return $result;

    }

    private function accessDataPush(){
        if( !$this->_checkSignature() ){
            if( !headers_sent() ){
                header('HTTP/1.1 404 Not Found');
                header('Status: 404 Not Found');
            }
            $this->_activeHook('404');
            return;
        }
        
        if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){
            if( !$this->_checkSignature() ) return;

            $postObj = simplexml_load_string(
                $GLOBALS["HTTP_RAW_POST_DATA"],
                'SimpleXMLElement', 
                LIBXML_NOCDATA
            );
            $postObj = $this->_handlePostObj($postObj);

            $this->_activeHook('receiveAllStart', $postObj);

            // Call Special Request Handle Function 
            if( isset( $postObj['event'] ) ){
                $hookName = 'receiveEvent::' . $postObj['event'];
            } else {
                $hookName = 'receiveMsg::' . $postObj['type'];
            }
            $this->_activeHook( $hookName, $postObj );
            
            $this->_activeHook('receiveAllEnd', $postObj);

        } else if( isset($_GET['echostr']) ){
            
            $this->_activeHook('accessCheckSuccess');
            // avoid of xss
            if( !headers_sent() ) header('Content-Type: text/plain');
            echo preg_replace('/[^a-z0-9]/i', '', $_GET['echostr']);
        }
    }

    private static $_from_id;
    private static $_my_id;
    private static function _format2xml( $nodes ){
        $xml = '<xml>'
            .     '<ToUserName><![CDATA[%s]]></ToUserName>'
            .     '<FromUserName><![CDATA[%s]]></FromUserName>'
            .     '<CreateTime>%s</CreateTime>'
            .     '%s'
            . '</xml>';
        return sprintf(
            $xml,
            self::$_from_id,
            self::$_my_id,
            time(),
            $nodes
        );
    }
    public static function getXml4Txt( $txt ){
        $xml = '<MsgType><![CDATA[text]]></MsgType>'
                . '<Content><![CDATA[%s]]></Content>';
        return self::_format2xml(
            sprintf(
                $xml,
                $txt
            )
        );
    }
    public static function getXml4ImgByMid( $mid ){
        $xml = '<MsgType><![CDATA[image]]></MsgType>'
                . '<Image>'
                .     '<MediaId><![CDATA[%s]]></MediaId>'
                . '</Image>';
        return self::_format2xml(
            sprintf(
                $xml,
                $mid
            )
        );
    }
    public static function getXml4VoiceByMid( $mid ){
        $xml = '<MsgType><![CDATA[voice]]></MsgType>'
                . '<Voice>'
                .     '<MediaId><![CDATA[%s]]></MediaId>'
                . '</Voice>';
        return self::_format2xml(
            sprintf(
                $xml,
                $mid
            )
        );
    }
    public static function getXml4VideoByMid( $mid, $title, $desc = '' ){
        $desc = '' !== $desc ? $desc : $title;
        $xml = '<MsgType><![CDATA[video]]></MsgType>'
                . '<Video>'
                .     '<MediaId><![CDATA[%s]]></MediaId>'
                .     '<Title><![CDATA[%s]]></Title>'
                .     '<Description><![CDATA[%s]]></Description>'
                . '</Video>';

        return self::_format2xml(
            sprintf(
                $xml,
                $mid,
                $title,
                $desc
            )
        );
    }
    public static function getXml4MusicByUrl( $url, $thumbmid, $title, $desc = '', $hqurl = '' ){
        $xml = '<MsgType><![CDATA[music]]></MsgType>'
                . '<Music>'
                .     '<Title><![CDATA[%s]]></Title>'
                .     '<Description><![CDATA[%s]]></Description>'
                .     '<MusicUrl><![CDATA[%s]]></MusicUrl>'
                .     '<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>'
                .     '<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>'
                . '</Music>';

        return self::_format2xml(
            sprintf(
                $xml,
                $title,
                '' === $desc ? $title : $desc,
                $url,
                $hqurl ? $hqurl : $url,
                $thumbmid
            )
        );
    }

    public static function getXml4RichMsgByArray( $list ){
        $max = 10;
        $i = 0;
        $ii = count( $list );
        $list_xml = '';
        while( $i < $ii && $i < $max ){
            $item = $list[ $i++ ];
            $list_xml .=
                sprintf(
                    '<item>'
                    .     '<Title><![CDATA[%s]]></Title> '
                    .     '<Description><![CDATA[%s]]></Description>'
                    .     '<PicUrl><![CDATA[%s]]></PicUrl>'
                    .     '<Url><![CDATA[%s]]></Url>'
                    . '</item>',
                    $item['title'],
                    $item['desc'],
                    $item['pic'],
                    $item['url']
                );
        }

        $xml = '<MsgType><![CDATA[news]]></MsgType>'
               . '<ArticleCount>%s</ArticleCount>'
               . '<Articles>%s</Articles>';

        return self::_format2xml(
            sprintf(
                $xml,
                $i,
                $list_xml 
            )
        );
            
    }
}

WeChatServer::$ERRCODE_MAP = array(
    'send success' => 'send success',
    'send fail'    => 'send fail',
    'err(10001)'   => 'err(10001)',
    'err(20001)'   => 'err(20001)',
    'err(20004)'   => 'err(20004)',
    'err(20002)'   => 'err(20002)',
    'err(20006)'   => 'err(20006)',
    'err(20008)'   => 'err(20008)',
    'err(20013)'   => 'err(20013)',
    'err(22000)'   => 'err(22000)',
    'err(21000)'   => 'err(21000)'
);
