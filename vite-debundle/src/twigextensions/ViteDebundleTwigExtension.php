<?php
/**
 * Vite debundle plugin for Craft CMS 3.x
 *
 * Debundle your Vite manifests in Craft
 *
 * @link      https://github.com/hungrysandwichclub
 * @copyright Copyright (c) 2021 Hungry Sandwich
 */

namespace hungrysandwichclub\vitedebundle\twigextensions;

use hungrysandwichclub\vitedebundle\ViteDebundle;

use Craft;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Hungry Sandwich
 * @package   ViteDebundle
 * @since     1.1.0
 */
class ViteDebundleTwigExtension extends AbstractExtension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'ViteDebundle';
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new TwigFilter('vitedebundle', [$this, 'debundle']),
        ];
    }

    /**
     * @param null $input
     *
     * @return array
     */
    public function debundle($input = null)
    {
        // Get manifest from input and json_decode it
        $path = $input;
        $assetsManifest = @json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $path), true) ?: [];

        // Todo: test how this functions with more than one html file
        $file = $assetsManifest['index.html'];

        // Initalise output array
        $output["css"] = [];
        $output["js"] = [];
        $output["assets"] = [];

        // Parse or build CSS
        if (is_array($file["css"])) {
            $output["css"] = $file["css"];
        } else {
            array_push($output["css"], $file["css"]);
        }

        // Parse or build JS
        if (is_array($file["file"])) {
            $output["js"] = $file["file"];
        } else {
            array_push($output["js"], $file["file"]);
        }

        // Parse or build Assets
        // Todo: how should these be incorpated into the build?
        if (is_array($file["assets"])) {
            $output["assets"] = $file["assets"];
        } else {
            array_push($output["assets"], $file["assets"]);
        }

        return $output;
    }
}
