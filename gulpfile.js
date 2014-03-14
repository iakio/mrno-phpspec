"use strict";
var gulp = require('gulp'),
    growly = require("growly"),
    exec = require('child_process').exec,
    cmd = require("path").normalize("bin/phpspec"),
    paths = {
        watch: "spec/**.php"
    };

gulp.task("phpspec", function () {
    var notify = function (msg) {
        growly.notify(msg, { title: "phpspec" });
    };
    return exec(cmd + " run", function (error, stdout, stderr) {
        console.log("stdout ", stdout);
    }).on('error', function () {
        notify("ERROR");
    }).on('exit', function (code) {
        if (code === 0) {
            notify("PASS");
        } else {
            notify("FAIL");
        }
    });
});

gulp.task("watch", function () {
    gulp.watch(paths.watch, ["phpspec"]);
});

gulp.task("default", ["phpspec", "watch"]);
