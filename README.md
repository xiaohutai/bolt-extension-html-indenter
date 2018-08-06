# HTML Indenter

A simple extension that properly indents HTML responses.


## Installation

Before installing this extension. You need to install [gajus/dindent](https://github.com/gajus/dindent):

```sh
composer require gajus/dindent
```

## Configuration

Edit `app/config/extension/htmlindenter.xiaohutai.yml` for options:

- indentation_character`: Characters used for indentation. Defaults to 4 spaces.
- `blocks`: List of HTML elements that will be output as blocks, such as `div`.
- `inline`: List of HTML elements that will be output as inline, such as `span`.
- `minify`: Overrides everything and minify HTML. Defaults to `false`.
