![Usain Bolt](bolt.gif)

# Vite debundler for Craft CMS 3.x

Tired of webpack?

Debundle manifestos from Vite bundler ⚡️

## Requirements

This module requires Craft CMS 3.0.0-RC1 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require /vite-debundle

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Vite debundle.

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

    {% set manifest = '/dist/manifest.json' %}
    {% set vite = manifest | vitedebundle %}

    {% for css in vite.css %}
        <link rel="stylesheet" href="/dist/{{ css }}">
    {% endfor %}

    {% for js in vite.js %}
        <script src="/dist/{{ js }}"></script>
    {% endfor %}

{% endif %}
```

## Vite debundle Roadmap

Some things to do, and ideas for potential features:

* Plugin settings panel - set path to build and server host IP/port
* Static Assets handling
