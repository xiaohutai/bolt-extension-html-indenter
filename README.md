# HTML Indenter

A simple extension that properly indents HTML responses.


## Configuration

Edit `app/config/extension/htmlindenter.xiaohutai.yml` for options:

- `enabled`: Whether to do anything at all or not. Defaults to `true`.
- `indentation_character`: Characters used for indentation. Defaults to 4 spaces.
- `blocks`: List of HTML elements that will be output as blocks, such as `div`.
- `inline`: List of HTML elements that will be output as inline, such as `span`.
- `minify`: Overrides everything and minify HTML. Defaults to `false`.


## References

- Based on [gajus/dindent](https://github.com/gajus/dindent).
- Based on [dactivo/Bolt.cm-HTML-minifier](https://github.com/dactivo/Bolt.cm-HTML-minifier).
