<?php
/**
 * Thunderblight plugin for Craft CMS 3.x
 *
 * Debundle your Vite manifests quickly
 *
 * @link      https://hungrysandwich.club
 * @copyright Copyright (c) 2021 Hungry Sandwich Club
 */

namespace hungrysandwichclub\thunderblight\twigextensions;

use hungrysandwichclub\thunderblight\Thunderblight;

use Craft;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @author    Hungry Sandwich Club
 * @package   Thunderblight
 * @since     1.0.0
 */
class ThunderblightTwigExtension extends AbstractExtension
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Thunderblight';
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new TwigFilter('thunderblight', [$this, 'debundle']),
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

        // Todo: test how this functions with more than one html file
        try {

            $assetsManifest = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $path), true) ?: [];
            $file = $assetsManifest['index.html'];

        } catch (\Exception $e) {

            Craft::log('The request to domain.com failed: '.$e->getMessage(),
               LogLevel::Warning, false, 'Thunderblight');

            return false;
        }

        // Initalise output array
        $output["css"] = [];
        $output["js"] = [];
        $output["assets"] = [];

        // Parse or build CSS
        if (array_key_exists("css", $file)) {
            if (is_array($file["css"])) {
                $output["css"] = $file["css"];
            } else {
                array_push($output["css"], $file["css"]);
            }
        }

        // Parse or build JS
        if (array_key_exists("file", $file)) {
            if (is_array($file["file"])) {
                $output["js"] = $file["file"];
            } else {
                array_push($output["js"], $file["file"]);
            }
        }

        // Parse or build Assets
        // Todo: how should these be incorpated into the build?
        if (array_key_exists("assets", $file)) {
            if (is_array($file["assets"])) {
                $output["assets"] = $file["assets"];
            } else {
                array_push($output["assets"], $file["assets"]);
            }
        }

        return $output;
    }
}
