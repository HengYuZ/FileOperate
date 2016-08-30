<?php
/**
 * Created by PhpStorm.
 * User: zhanghengyu
 * Date: 2016/8/30
 * Time: 14:11
 */
namespace Message;
class MessageBoard
{
    private $username;
    private $content;
    private $msgTimestamp;

    public function __construct($username, $content)
    {
        if ($username && $content) {
            $this->username = htmlspecialchars($username);
            $this->content = htmlspecialchars($content);
            $this->msgTimestamp = date('Y-m-d H:i:s', time());
        }
    }

    //把留言写入文件
    public function writeHandle()
    {
        $filePoint = fopen('msgContent.txt', 'a');
        fwrite($filePoint, $this->msgTimestamp . "\r\n");
        fwrite($filePoint, $this->username . "\r\n");
        fwrite($filePoint, $this->content . "\r\n");
        fclose($filePoint);
    }
}

date_default_timezone_set('UTC');
$messageBoardObj = new MessageBoard($_POST["username"], $_POST["content"]);
$messageBoardObj->writeHandle();
echo "<script>window.location='index.php'</script>";