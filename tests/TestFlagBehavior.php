<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'CBehavior.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'MockFlagBehavior.php';

/**
 * Bits data
 * @author Tarasov Konstantin
 */
class TestFlagBehavior extends PHPUnit_Framework_TestCase
{
    public function testExtention()
    {
        $model = new MockFlagBehavior();

        $model->setFlag(MockFlagBehavior::SETTINGS_ENABLED);
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED));
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED), false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED), false);

        $model->setFlag(MockFlagBehavior::SETTINGS_AVAILABLED);
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED));
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED));
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED), false);

        $model->setFlag(MockFlagBehavior::SETTINGS_ACTVATED);
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED));
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED));
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED));

        $model->setFlag(MockFlagBehavior::SETTINGS_ENABLED, false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED), false);
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED));
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED));

        $model->setFlag(MockFlagBehavior::SETTINGS_AVAILABLED, false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED), false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED), false);
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED));

        $model->setFlag(MockFlagBehavior::SETTINGS_ACTVATED, false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED), false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED), false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED), true);
    }
}