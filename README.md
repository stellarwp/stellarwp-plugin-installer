# StellarWP Plugin Installer

Show the free plugins from StellarWP brands as recommended plugins on the Add New Plugin screen.

## Adding to your project

This can either be installed normally as a plugin, or loaded via composer to an existing project.

In your composer.json, add the following (you may already have a repositories array).

```json
"repositories": [
 {
    "type": "vcs",
    "url": "git@github.com:stellarwp/stellarwp-plugin-installer.git"
  }
]
```

## Available filters

`swp_installer_suggested_plugins` can be used to modify the recommended plugins.
