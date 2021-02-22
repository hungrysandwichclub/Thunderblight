<?php
/**
 * Vite debundle module for Craft CMS 3.x
 *
 * Debundle manifestos from Vite bundler ⚡️
 *
 * @link      https://github.com/hungrysandwichclub
 * @copyright Copyright (c) 2021 Hungry Sandwich
 */

namespace modules\vitedebundlemodule;

use modules\vitedebundlemodule\assetbundles\vitedebundlemodule\ViteDebundleModuleAsset;
use modules\vitedebundlemodule\twigextensions\ViteDebundleModuleTwigExtension;

use Craft;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\TemplateEvent;
use craft\i18n\PhpMessageSource;
use craft\web\View;

use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\base\Module;

/**
 * Class ViteDebundleModule
 *
 * @author    Hungry Sandwich
 * @package   ViteDebundleModule
 * @since     1.0.0
 *
 */
class ViteDebundleModule extends Module
{
    // Static Properties
    // =========================================================================

    /**
     * @var ViteDebundleModule
     */
    public static $instance;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@modules/vitedebundlemodule', $this->getBasePath());
        $this->controllerNamespace = 'modules\vitedebundlemodule\controllers';

        // Translation category
        $i18n = Craft::$app->getI18n();
        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (!isset($i18n->translations[$id]) && !isset($i18n->translations[$id.'*'])) {
            $i18n->translations[$id] = [
                'class' => PhpMessageSource::class,
                'sourceLanguage' => 'en-US',
                'basePath' => '@modules/vitedebundlemodule/translations',
                'forceTranslation' => true,
                'allowOverrides' => true,
            ];
        }

        // Base template directory
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, function (RegisterTemplateRootsEvent $e) {
            if (is_dir($baseDir = $this->getBasePath().DIRECTORY_SEPARATOR.'templates')) {
                $e->roots[$this->id] = $baseDir;
            }
        });

        // Set this as the global instance of this module class
        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$instance = $this;

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Event::on(
                View::class,
                View::EVENT_BEFORE_RENDER_TEMPLATE,
                function (TemplateEvent $event) {
                    try {
                        Craft::$app->getView()->registerAssetBundle(ViteDebundleModuleAsset::class);
                    } catch (InvalidConfigException $e) {
                        Craft::error(
                            'Error registering AssetBundle - '.$e->getMessage(),
                            __METHOD__
                        );
                    }
                }
            );
        }

        Craft::$app->view->registerTwigExtension(new ViteDebundleModuleTwigExtension());

        Craft::info(
            Craft::t(
                'vite-debundle-module',
                '{name} module loaded',
                ['name' => 'Vite debundle']
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================
}
