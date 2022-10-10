const { series, parallel, watch, task, src, dest } = require('gulp');
const concat = require('gulp-concat');
const rename = require('gulp-rename');
const uglify = require('gulp-uglify');
const sass = require('sass');
const fs = require('fs');


const clean = (cb) => {
  console.log('running task');
  cb();
}


const sassCompile = (cb) => {
  const file = 'assets/sass/app.sass';
  const result = sass.compile(file, { style: "compressed", sourceMap: true });
  fs.writeFile('assets/css/app.css', result.css, function (err) {
    if (err) return console.log(err);
  });
  cb()
}



const javascript = () => {
  return src(['assets/js/custom/*.js'])
    .pipe(concat('assets/js/app.js'))
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest('./'));

}

task('build', function (cb) {
  // body omitted
  watch([
    'assets/sass/*.sass',
    'assets/sass/*/*.sass',
    'assets/js/**/*.js'],
    series(clean, parallel(javascript, sassCompile)));
  cb();
});