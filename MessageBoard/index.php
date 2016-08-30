<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>我的留言本</title>
    <style type="text/css">

        body {
            font: 12px Verdana, Geneva, sans-serif;
        }

        h1, h2 {
            font-size: 20px;
            font-weight: normal;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            width: 800px;
        }

        h2 {
            margin-top: 100px;
        }

        .txt {
            width: 400px;
        }

        textarea {
            width: 400px;
            height: 100px;
        }

        dl dt {
            line-height: 30px;
        }

        dl dd {
            color: #666;
        }

    </style>
</head>

<body>

<h1>我的留言本</h1>
<dl>
    <?php
    $tmpArr = array();
    $filePoint = fopen('msgContent.txt', 'r');
    if ($filePoint) {
        while (($buffer = fgets($filePoint, 4096)) !== false) {
            $tmpArr[] = $buffer;
        }
    }
    fclose($filePoint);
    $tmpStr = '';
    foreach ($tmpArr as $key => $msgInfo) {
    ?>
    <dt>
        <?php
        if ($key % 3 == 0) {
            $tmpStr = $msgInfo;
        }
        if ($key % 3 == 1) {
            $tmpStr .= $msgInfo . ":";
        }
        if ($key % 3 == 2)
            echo $tmpStr;
        ?>
    </dt>
    <dd>
        <?php
        if ($key % 3 == 2) {
            echo $msgInfo;
        }
        } ?>
    </dd>
</dl>

<h2>我要留言</h2>
<form action="msgHandle.php" method="post">
    <table>
        <tbody>
        <tr>
            <th>昵称：</th>
            <td><input class="txt" type="text" name="username"></td>
        </tr>
        <tr>
            <th>内容：</th>
            <td>
                <textarea name="content"></textarea>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" value="提交"></button>
            </td>
        </tr>
        </tbody>
    </table>
</form>
</body>
</html>