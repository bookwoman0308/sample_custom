Sample Custom module

To install:

Place in [webroot]/modules directory, then enable this module and the dependency as with any other custom modules.


About the module:

I used hook_block_access in the module file to restrict block display to only nodes of the specified content type.

For the italicized text that appears on Sample Custom Article nodes, I used hook_preprocess_node to add the text. To keep all changes within one custom module and use the Bartik theme, I did not create a new custom theme.