# Amos Chat 

Plugin to manage private messages, conversations with user contacts.

### Installation

Add chat requirement in your composer.json:
```
"open20/amos-chat": "dev-master",
```

Enable the Chat modules in modules-amos.php, add :
```
 'chat' => [
	'class' => 'open20\amos\chat\AmosChat',
 ],

```
add chat migrations to console modules (console/config/migrations-amos.php):
```
'@vendor/open20/amos-chat/src/migrations'
```

### Configurable fields 

Here the list of configurable fields, properties of module AmosChat.
If some property default is not suitable for your project, you can configure it in module, eg: 

```php
 'chat' => [
	'class' => 'open20\amos\chat\AmosChat',
	'immediateNotificationForce' => false, //changed property (default was true)
 ],
 
```

* **formRedactorButtons** - array, default = ['file']  
List of all Redactor visible buttons in message form
```php
'chat' => [
    'class' => 'open20\amos\chat\AmosChat',
    'formRedactorButtons' => ['image', 'file']
],
```
* **immediateNotificationForce** - boolean, default = true  
Force notification sending to the message receiver

* **defaultEmailSender** - string
Default e-mail sender if the server allow only sender with the same domain

* **subjectOfimmediateNotification** - string
Default subject for emails of "immediate notification force". If in the module settings override the value, you detach translation system

* **enableForwardMessage** - boolean, default = false  
used to enable the forwarding of messages. It's required to insert an array of user_id in the variable $userIdForwardMessage

* **userIdForwardMessage** - (array) integer , default = []  
It's required to enable the function of forwarding message, it contain the list of user to which forward the messages

* **onlyNetworkUsers** - boolean, default = true  

* **subjectOfimmediateNotification** - string
Default subject for emails of "immediate notification force". If in the module settings override the value, you detach translation system

* **emailMessageContentAllowedTag** - string, default = 'p,div'

* **enableVideoconference** - boolean, default = false  

* **assistanceUserId** - integer, default = 1
User Id of the assistance user to open a conversation on click on WidgetIconChatAssistance
