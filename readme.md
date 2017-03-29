PHP Wrapper to send [line notify](https://notify-bot.line.me) notification

**Installation:**  `composer require renlight10/line-notify` 

 **usage :** 
``` php
$line = new \renlight10\LineNotify\LineNotify("token");
$line->SETmessage("awesome!");
echo $line->sendIt();
```
you can `SET` more property for example
``` php
$line->SETmessage("awesome!")->SETstickerPackageId(1)->SETstickerId(5);
```
see [documentation](https://notify-bot.line.me/doc/en/).

 **NOTE :** currently direct image upload or ` imageFile ` not supported ~

 **example response:** 
``` json
{"header":{"Limit":1000,"ImageLimit":50,"Remaining":999,"ImageRemaining":50,"Reset":1483555725},"body":{"status":200,"message":"ok"}}
```