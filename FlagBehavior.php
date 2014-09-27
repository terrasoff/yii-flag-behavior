<?php
/**
 * Bits data
 * @author Tarasov Konstantin
 */
class FlagBehavior extends CBehavior
{
    public $errorCode = '500';

    /**
     * Model's bit field name
     * Use type INT|BIGINT for MySQL
     * @var string
     */
    public $fieldName = 'settings';

    /**
     * Flags collection,
     *
     * WARNING!
     * Once defined flag's index (bit's order) never change it!.
     * @var array
     */
    public $flags = array();

    /**
     * Set specified flag value
     * @param string $name
     * @param bool $value
     * @return int new field value
     */
    public function setFlag($name, $value = true) {
        $object = $this->getOwner();
        $flags = $object->{$this->fieldName};
        return $object->{$this->fieldName} = $value
            ? $flags | $this->getFlagValue($name) // set
            : $flags ^ $this->getFlagValue($name); // unset
    }

    /**
     * Unset specified flag value
     * Could use both clearFlag(User::SETTINGS_ENABLED) or setFlag(User::SETTINGS_ENABLED, false)
     * @param $name
     * @return int
     */
    public function clearFlag($name) {
        return $this->setFlag($name, false);
    }

    /**
     * Is specified flag set?
     * @param $name
     * @return bool
     */
    public function hasFlag($name) {
        $object = $this->getOwner();
        $flag = $this->getFlagValue($name);
        return ($object->{$this->fieldName} & $flag) === $flag;
    }

    /**
     * Get flag index (bit's order) in collection
     * @param $name
     * @return int
     * @throws CException
     */
    public function getFlagIndex($name) {
        if (!isset($this->flags[$name]))
            throw new \Exception("Model flag {$name} not found");
        return $this->flags[$name];
    }

    /**
     * Get flag value
     * @param $name
     * @return number
     */
    public function getFlagValue($name) {
        return pow(2,$this->getFlagIndex($name));
    }

    /**
     * Search by flags
     * @param $flags
     * @return CActiveRecord
     */
    public function scopeFlags($flags) {
        /** @var $object CActiveRecord */
        $flags = $this->mergeFlags($flags);
        $object = $this->getOwner();
        $object->getDbCriteria()->mergeWith(array(
            'condition'=>$this->fieldName.' & :flag = :flag',
            'params' => array(':flag' => $flags),
        ));
        $object->getDbCriteria()->params[':flag'] = $flags;

        return $object;
    }

    /**
     * Get combined flags value
     * @param $flags
     * @return int
     */
    private function mergeFlags($flags) {
        return (int)array_reduce($flags, function($result, $value) {
            return $result = $result | pow(2, $value);
        });
    }

}