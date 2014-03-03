<?php
/**
 * Bits data operations
 * @author Tarasov Konstantin
 */
class FlagBehavior extends CBehavior
{
    public $errorCode = '500';
    /**
     * Model's bit field name
     * Use type BIT(N) for MySQL
     * @var string
     */
    public $fieldName = 'flags';

    /**
     * Flags collection,
     * ---
     * For example:
     * array(
     *      User::SETTINGS_ENABLED => 0,
     *      User::SETTINGS_ACTVATED => 1,
     *      User::SETTINGS_BANED => 2,
     *      ...
     * )
     * ---
     * WARNING! The order of flags is very important.
     * Once defined never change it!.
     *
     * Values 0,1,2... are bit's order.
     * Trying to get better perfomance keys are strings (not to use array_search)
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
            ? $flags | $this->getFlagValue($name)
            : $flags ^ $this->getFlagValue($name);
    }

    /**
     * Unset specified flag value
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
            throw new CException($this->errorCode, "Model flag {$name} not found");
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

}