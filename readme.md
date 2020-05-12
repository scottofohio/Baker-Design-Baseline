#Baker Design Baseline Theme

## Getting Started

### Grunt 
This theme uses Grunt to compile and minify scss and javascript. Please make sure you have node and grunt installed globally in your development enviroment. Then you should be able to run the following commands in the theme directory. 

`$ grunt debug`

This command will build all css and js files unminified and will help to alert of any errors. 

`$ grunt `

This command will build and minify all css and js files. 

### Bootstrap 
This theme is utilizing parts of Twitter Bootstrap that have been modified to be more semeantic. If you feel the need to include the class based twitter grid system you can enable it by uncommenting the `@import grid` in the `/assets/scss/bootstrap/boostrap.scss` file. 

If you want to use the bootstrap grid mixins they have been modified to enable CSS grid with flexbox as the fallback. 

In order to use the grid mixins you need to create a wrapper element and children elements in your html and apply the following mixins located in `/assets/scss/bootstrap/mixins/grid.scss`

`@make-row();`
`@make-col();`

Most everything else is pretty standard bootstrap stuff.

## Assets 
All theme images, css and js are in the assets folder. Do not use the style.css file in the root of the theme. 