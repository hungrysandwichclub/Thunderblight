<?php
/**
 * Thunderblight plugin for Craft CMS 3.x
 *
 * Debundle your Vite manifests quickly
 *
 * @link      https://hungrysandwich.club
 * @copyright Copyright (c) 2021 Hungry Sandwich Club
 */

namespace hungrysandwichclub\thunderblight;

use hungrysandwichclub\thunderblight\twigextensions\ThunderblightTwigExtension;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;

use yii\base\Event;

/**
 * Class Thunderblight
 *
 * @author    Hungry Sandwich Club
 * @package   Thunderblight
 * @since     1.0.0
 *
 */
class Thunderblight extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Thunderblight
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = false;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Craft::$app->view->registerTwigExtension(new ThunderblightTwigExtension());

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'thunderblight',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
