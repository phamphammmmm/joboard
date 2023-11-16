<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>Document</title>
    <style>
    html,
    body {
        color: #ae2070;
        font-family: 'Roboto', sans-serif;
    }

    .checkout-button {
        display: flex;
        align-items: center;
        border: 1px solid #ae2070;
        padding: 5px;
        border-radius: 5px
    }

    .checkout-button img {
        padding-left: 10px;
        height: 50px;
        width: 50px;
    }

    .content {
        padding-left: 15px;
    }

    .content .checkout-title {
        color: #000;
        font-size: 13pt;
        font-weight: 600;
    }

    .content .description {
        color: #666
    }

    input[type="radio"]:hover {
        cursor: pointer;
    }
    </style>
</head>

<body>
    <div class="checkout-button">
        <input type="radio" />
        <div class="content">
            <div class="checkout-title">
                Thanh toán bằng <b>Ví MoMo</b>
            </div>
        </div>
    </div>
    <br />
    <div class="checkout-button">
        <div class="checkout-selector">
            <input type="radio" class="btn btn-m2 btn-checkout btn-logo-inline">
        </div>
        <div class="content" style="  display: flex;
  align-items: center;">
            <span class="checkout-title">
                Thanh toán bằng
            </span>
            <img src="https://developers.momo.vn/images/logo.png" width="25" />
        </div>
    </div>
    <br />
    <div class="checkout-button">
        <input type="radio" />
        <img class="logo" src="https://developers.momo.vn/images/logo.png" width="25" />
        <div class="content">
            <div class="checkout-title">
                Thanh toán bằng Ví MoMo
            </div>
            <div class="description">
                <!--       Guide user pays with MoMo E-wallet -->
                <!--       Replace by your content -->
                Quý khách vui lòng cài đặt Ví MoMo trước khi thanh toán. <a
                    href="https://momo.vn/huong-dan/huong-dan-tai-va-cai-dat-vi-momo">Hướng dẫn</a>
            </div>
        </div>
    </div>
</body>

</html>