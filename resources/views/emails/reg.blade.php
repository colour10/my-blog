<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>

<body>
    <p>尊敬的{{ $name }}，非常感谢您注册刘宗阳博客~</p>

    <p>您的初始密码为：{{ $password }}，请妥善保管。</p>

    <p>
        请点击下面的链接激活您的帐号：
        <a href="{{ $url }}" target="_blank">
            {{ $url }}
        </a>
    </p>

    <p>
        如果这不是您本人的操作，请忽略此邮件。
    </p>
</body>

</html>