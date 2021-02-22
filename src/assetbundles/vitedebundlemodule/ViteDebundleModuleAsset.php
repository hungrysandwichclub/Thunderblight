<?php
/**
 * Vite debundle module for Craft CMS 3.x
 *
 * Debundle manifestos from Vite bundler ⚡️
 *
 * @link      https://github.com/hungrysandwichclub
 * @copyright Copyright (c) 2021 Hungry Sandwich
 */

namespace modules\vitedebundlemodule\assetbundles\vitedebundlemodule;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Hungry Sandwich
 * @package   ViteDebundleModule
 * @since     1.0.0
 */
class ViteDebundleModuleAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@modules/vitedebundlemodule/assetbundles/vitedebundlemodule/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/ViteDebundleModule.js',
        ];

        $this->css = [
            'css/ViteDebundleModule.css',
        ];

        parent::init();
    }
}
