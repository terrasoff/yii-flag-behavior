<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'FlagBehavior.php';

/**
 * Mock class for testing
 * @author Tarasov Konstantin
 */
class MockFlagBehavior extends FlagBehavior
{
    const SETTINGS_ENABLED = 'enabled';
    const SETTINGS_ACTVATED = 'activated';
    const SETTINGS_AVAILABLED = 'availabled';

    public $settings;
    public $fieldName = 'settings';

    public $flags = [
        self::SETTINGS_ACTVATED => 0,
        self::SETTINGS_AVAILABLED => 1,
        self::SETTINGS_ENABLED => 2,
    ];
}