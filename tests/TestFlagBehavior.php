<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'CBehavior.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'MockFlagBehavior.php';

/**
 * Testing behavior
 * @author Tarasov Konstantin
 */
class TestFlagBehavior extends PHPUnit_Framework_TestCase
{
    public function testExtention()
    {
        $model = new MockFlagBehavior();

        $model->setFlag(MockFlagBehavior::SETTINGS_ACTVATED);
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED));
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED), false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED), false);
        $this->assertEquals($model->settings, 1);

        $model->setFlag(MockFlagBehavior::SETTINGS_AVAILABLED);
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED));
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED));
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED), false);
        $this->assertEquals($model->settings, 3);

        $model->setFlag(MockFlagBehavior::SETTINGS_ENABLED);
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED));
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED));
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED));
        $this->assertEquals($model->settings, 7);

        $model->setFlag(MockFlagBehavior::SETTINGS_ACTVATED, false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED), false);
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED));
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED));
        $this->assertEquals($model->settings, 6);

        $model->setFlag(MockFlagBehavior::SETTINGS_AVAILABLED, false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED), false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED), false);
        $this->assertTrue($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED));
        $this->assertEquals($model->settings, 4);

        $model->setFlag(MockFlagBehavior::SETTINGS_ENABLED, false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ACTVATED), false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_AVAILABLED), false);
        $this->assertFalse($model->hasFlag(MockFlagBehavior::SETTINGS_ENABLED), true);
        $this->assertEquals($model->settings, 0);
    }
}