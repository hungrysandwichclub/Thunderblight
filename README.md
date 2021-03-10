# Thunderblight

[![Craft CMS](https://img.shields.io/badge/Craft%20CMS-3.x-red)](https://craftcms.com)

![Usain Bolt](bolt.gif)

**Tunderblight is a Craft CMS plugin which makes using Vite ⚡️ manifest files easy.**

Extends twig to decode the manifest.json format produced by Vite on build.

## Requirements

This module requires Craft CMS 3.0.0-RC1 or later.

## Installation

Install the plugin using composer in your Craft project:

    composer require hungrysandwichclub/thunderblight

## Usage

Once installed activated in Craft (Settings → Plugins) you can then use Thunderblight in your twig files as a filter:

```
{% set manifest = 'path/to/manifest.json' %}
{% set vite = manifest | thunderblight %}
```

This will look for a manifest file created by Vite, you must specify this in your Vite config by setting the `build.output` path. You will need to also enable the `build.manifest` option by setting it to true. For more information please check the [Vite Config Documention.](https://vitejs.dev/config/#build-options)

With this object you can then output your static files and assets like so:

```
{% for css in vite.css %}
    <link rel="stylesheet" href="{{ siteUrl }}/dist/{{ css }}">
{% endfor %}

{% for js in vite.js %}
    <script src="{{ siteUrl }}/dist/{{ js }}"></script>
{% endfor %}
```

This will support chunking of files.

We recommend using Craft's Environment variable found in your .env file to make appropriate checks to serve correct files. More information can be found in the [Craft Documentation](https://craftcms.com/docs/3.x/config/#environmental-configuration) about configuring your project.

```
{% set env = getenv('ENVIRONMENT') %}
```

### Vite Config

With this setup your project will now work with your build files after running `npm run build` in your vite src folder. But how about local development? I hear you ask.

If you're running your Craft installation locally we recommend running the Vite dev server on a different port to your current project, then we can treat the dev server as an external host for our files and retrieve them like we would from a CDN. For more information on setting this up please check Vite's [Backend Intergration Guide.](https://vitejs.dev/guide/backend-integration.html).

With the above teachings applied we'd include our files like so:

    <link rel="stylesheet" href="http://localhost:3000/scss/_entry.scss" />
    <script type="module" src="http://localhost:3000/@vite/client"></script>
    <script type="module" src="http://localhost:3000/js/_entry.js"></script>

We've included an example `vite.config.js` file in the `example` folder in this repo to get you up and running quickly.

With all these steps in place we have the following code:

```
{% set env = getenv('ENVIRONMENT') %}

{% if env == 'dev' %}

    <link rel="stylesheet" href="http://localhost:3000/scss/_entry.scss" />
    <script type="module" src="http://localhost:3000/@vite/client"></script>
    <script type="module" src="http://localhost:3000/js/_entry.js"></script>

{% else %}

    {% set manifest = '{{ siteurl }}/dist/manifest.json' %}
    {% set vite = manifest | vitedebundle %}

    {% for css in vite.css %}
        <link rel="stylesheet" href="{{ siteUrl }}/dist/{{ css }}">
    {% endfor %}

    {% for js in vite.js %}
        <script src="{{ siteUrl }}/dist/{{ js }}"></script>
    {% endfor %}

{% endif %}
```

We've left this open to your interpretation should you prefer to load your assets using a different strategy, we'd love to hear your thoughts on how this could be improved!

## Thunderblight roadmap

Some things to do, and ideas for potential features:

* Plugin settings panel - set path to build and server host IP/port
* Handling multiple Vite pages in the Manifest
* Static Assets handling

## Useful Links and Credits

* https://github.com/andrefelipe/vite-php-setup
* https://github.com/clubstudioltd/craft-asset-rev
* https://plugins.craftcms.com/twigpack
