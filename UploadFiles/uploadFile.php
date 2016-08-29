<?php
/**
 * Created by PhpStorm.
 * User: zhanghengyu
 * Date: 2016/8/29
 * Time: 17:42
 */
namespace File;

class uploadFile
{
    //存储文件上传类型
    private $allowType = array();
    //上传文件的保存路径
    private $path;
    //上传文件大小
    private $fileSize;
    //上传文件个数
    private $fileNum;
    //保存的文件名
    public $saveFileName;

    public function setUploadRules($allowType, $path, $fileSize)
    {
        foreach ($allowType as $type)
            $this->allowType[] = $type;
        $this->path = $path;
        $this->fileSize = $path;
        $this->fileSize = $fileSize;
        //$this->fileNum = $fileNum;
    }

    //上传错误信息反馈方法
    public function uploadMessage($errorCode)
    {
        echo "上传错误,";
        switch ($errorCode) {
            case 1:
                die('上传文件大小超出了PHP设置文件的约定值');
            case 2:
                die('上传文件大小超出了表单中的约定值');
            case 3:
                die('文件只有部分上传了');
            case 4:
                die('没有上传文件');
            default:
                die('未知错误');
        }
    }

    //上传结果
    public function uploadResult()
    {
        $errorCode = $_FILES['file']['error'];
        if ($errorCode > 0)
            $this->uploadMessage($errorCode);
        else if ($errorCode == 0) {
            $parts = explode('.', $_FILES['file']['name']);
            $suffix = end($parts);
            if (!in_array($suffix, $this->allowType)) {
                die("后缀为{$suffix}的文件不允许上传");
            }

            if ($_FILES['file']['size'] > $this->fileSize) {
                echo $this->fileSize;
                die("文件超过{$this->fileSize}了");
            }
            //防止上传文件同名被覆盖掉
            $this->saveFileName = date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . rand(100, 999) . "." . $suffix;
            //判断是否是上传文件
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                if (!move_uploaded_file($_FILES['file']['tmp_name'], $this->path . '/' . $this->saveFileName))
                    die('问题：不能将文件移动到指定目录');
            } else
                die("问题：上传文件{$_FILES['file']['name']}不是合法文件");
            return true;
        }
    }
}

date_default_timezone_set('UTC');
$uploadfile = new uploadFile();
//允许上传的文件格式
$arr = array("gif", "png", "jpg", "txt");
//上传文件设定保存在当前的目录下的upload文件夹下，上传文件最大为2M
$uploadfile->setUploadRules($arr, './upload', 2000000);
if ($uploadfile->uploadResult())
    echo "文件上传成功，文件" . $_FILES['file']['name'] . "保存在upload文件夹下,名字为$uploadfile->saveFileName";
