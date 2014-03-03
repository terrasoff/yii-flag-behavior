Usually model contains flag fields. For example model User could contain fields

* <b>enabled</b> - is user enabled?
* <b>activated</b> - is user activated?
* <b>baned</b> - is user baned?
* ...

I've seen many people use multiple fields to store this information.
Other way to store each field in bits representation:
Bits "001" mean 'not enabled', 'not activated', 'baned'.

In case of MySQL we could use BIT(N) type of fields. So we can store 64 fields in one.

How to use this behavior

## Add model behavior

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

    $user->settings = 6; // let's our user is activated and baned
    $user->setFlag(User::SETTINGS_ENABLED); // add flag
    if ($user->hasFlag(User::SETTINGS_ENABLED)) // and remove it (if set)
        $user->setFlag(User::SETTINGS_ENABLED, false);
    $user->setFlag(User::SETTINGS_BANED); // set again
    $user->clearFlag(User::SETTINGS_BANED); // remove
    $user->setFlag(User::SETTINGS_BANED); // and set again
    echo $user->settings; // what is result? 6 Sure! It wasn't changed
    $user->save();

## Search

How to search users using flags? For example find users who baned;
Mask is 100. Now compare mask and settings field:

    SELECT * FROM User WHERE settings & mask = mask

# Roadway

* Search scope