# Webpack + Typescript + Sass + Wordpress

A Wordpress starter theme powered by Webpack, Typescript, and Sass.

## Usage

1. Clone copy the repository into your `wp-content/themes` folder
2. Install dependencies with `yarn install`
3. Develop with `yarn dev`
4. Build for production with `yarn build`

A `build` directory is created with all of the deployable files. You should upload the entire build directory and the acf json folder as the theme. The webserver should look like this:

```
wp-content
└── themes
   └── webpack-typescript-sass-wordpress
      ├── acf-json
      └── build
```

## Dependencies

### Advanced Custom Fields

[Advanced Custom Fields PRO](https://www.advancedcustomfields.com/pro/) is required for this theme to work properly.

### Font Awesome

The theme comes configured with Font Awesome 5 Free.

If you have a Pro account:

1. Configure npm as outlined here: [Font Awesome - Using a Package Manager](https://fontawesome.com/v5.9.0/how-to-use/on-the-web/setup/using-package-managers)
2. Update packages:
   ```
   yarn uninstall @fortawesome/fontawesome-free
   yarn install @fortawesome/fontawesome-pro
   ```
3. Modify `./scss/_font-awesome.scss` (uncomment pro package references / remove free package references.)
