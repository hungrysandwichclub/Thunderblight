# Vite debundle module for Craft CMS 3.x

Debundle manifestos from Vite bundler ⚡️

## Requirements

This module requires Craft CMS 3.0.0-RC1 or later.

## Installation

To install the module, follow these instructions.

Firstly add the contents of this repo to a folder in your Modules folder named "vitedebundlemodule".

```
/modules/vitedebundlemodule
```

Next you'll need to add the contents of the `app.php` file to your `config/app.php` (or just copy it there if it does not exist). This ensures that your module will get loaded for each request. The file might look something like this:
```
return [
    'modules' => [
        'vite-debundle-module' => [
            'class' => \modules\vitedebundlemodule\ViteDebundleModule::class,
        ],
    ],
    'bootstrap' => ['vite-debundle-module'],
];
```
You'll also need to make sure that you add the following to your project's `composer.json` file so that Composer can find your module:

    "autoload": {
        "psr-4": {
          "modules\\vitedebundlemodule\\": "modules/vitedebundlemodule/src/"
        }
    },

After you have added this, you will need to do:

    composer dump-autoload

 …from the project’s root directory, to rebuild the Composer autoload map. This will happen automatically any time you do a `composer install` or `composer update` as well.

## Using Vite debundle

Once installed you can then use Vite debundle in your twig files as a filter:

```
% set manifest = 'path/to/manifest.json' %}
{% set vite = manifest | vitedebundle %}
```

With this variable you can then output your static files and assets like so:

```
{% for css in vite.css %}
    <link rel="stylesheet" href="/assets/{{ css }}">
{% endfor %}

{% for js in vite.js %}
    <script src="/assets/{{ js }}"></script>
{% endfor %}
```

This will support chunking of files.

We recommend using the Craft environment variable found in your .env file to make appropriate checks to serve correct files:

```
{% set env = getenv('ENVIRONMENT') %}
```

Thus giving us the complete code:

```
{% set env = getenv('ENVIRONMENT') %}

{% if env == 'dev' %}

    <link rel="stylesheet" href="http://localhost:3000/scss/_entry.scss" />
    <script type="module" src="http://localhost:3000/@vite/client"></script>
    <script type="module" src="http://localhost:3000/js/_entry.js"></script>

{% else %}

    {% set manifest = '/assets/manifest.json' %}
    {% set vite = manifest | vitedebundle %}

    {% for css in vite.css %}
        <link rel="stylesheet" href="/assets/{{ css }}">
    {% endfor %}

    {% for js in vite.js %}
        <script src="/assets/{{ js }}"></script>
    {% endfor %}

{% endif %}
```

## Vite debundle Roadmap

Some things to do, and ideas for potential features:

* Easier installation - NPX or Craft Plugin?
* Static Assets handling
