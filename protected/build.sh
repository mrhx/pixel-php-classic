#!/bin/bash

uglifyjs ../js/app.js -c -m -o ../js/app.min.js
uglifycss ../css/app.css > ../css/app.min.css
