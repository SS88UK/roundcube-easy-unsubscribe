# Roundcube Easy Unsubscribe
Displays a small icon after the subject line when viewing an email, so you can very quickly unsubscribe. Multiple icons may show as the plugin is reliant upon the `List-Unsubscribe` header. Sometimes emails use multiple i.e. one mailto: and one URL.


## Demo Visual
![Demo SS](https://i.ibb.co/58B3P57/Screenshot-2023-11-29-at-12-42-46-PM.png)

## Deployment

Download a copy of this repo and upload the contents to:
```
/path/to/roundcube/plugins/easy_unsubscribe
```

Edit your `/path/to/roundcube/config/config.inc.php` file and add `easy_unsubscribe` to the `$config['plugins']` variable. It should look something like the following: 

```
$config['plugins'] = array(
    'password',
    'easy_unsubscribe'
);
```
