# Description
Usually model contains flag fields. For example model User could contain fields

* *enabled* - is user enabled?
* *activated* - is user activated?
* *baned* - is user baned?
* ...

I've seen many people use multiple fields to store this information.
Other way to store each field in bits representation:
Bits "001" mean 'not enabled', 'not activated', 'baned'.

In case of MySQL we could use INT, BIGINT or BIT(N) type or  of fields. So we can store up to 64 fields in one.

#How to use this behavior

## Add model behavior
	// must be defined
    const SETTINGS_ENABLED = 'enabled';
    const SETTINGS_ACTVATED = 'activated';
    const SETTINGS_ACTVATED = 'baned';

    public function behaviors()
    {
        return array(
            'FlagBehavior'=>array(
                'class'=>'ext.yii-flag-behavior.FlagBehavior',
                'fieldName'=>'settings',
                'errorCode'=>HttpResponse::STATUS_SERVER_ERROR,
                'flags'=>array(
                    User::SETTINGS_ENABLED => 0,
                    User::SETTINGS_ACTVATED => 1,
                    User::SETTINGS_BANED => 2,
                ),
            ),
        );
    }

## Manipulate

    $user->settings = 6; // let's our user is activated and baned (110)
    $user->setFlag(User::SETTINGS_ENABLED); // add flag (now 111)
    if ($user->hasFlag(User::SETTINGS_ENABLED)) // and remove it (if set)
        $user->setFlag(User::SETTINGS_ENABLED, false); // now 110 again
    $user->setFlag(User::SETTINGS_BANED); // set again (nothing changed)
    $user->clearFlag(User::SETTINGS_BANED); // remove (010)
    $user->setFlag(User::SETTINGS_BANED); // and set again (110)
    echo $user->settings; // what is result? 6 Sure (110)! It wasn't changed

## Search

How to search users using flags? For example find users who baned;
Mask is 100. Now compare mask and settings field:
    SELECT * FROM User WHERE flags & mask = mask

Using behavior's scope:
	$settings = array(
		User::SETTINGS_ENABLED,
		User::SETTINGS_ACTVATED,
	);
    $user = User::model()->scopeFlag($settings)->findAll();

# Roadway

* testing...