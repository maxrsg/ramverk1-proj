# Ramverk1 slutprojekt

[![Build Status](https://scrutinizer-ci.com/g/maxrsg/ramverk1-proj/badges/build.png?b=main)](https://scrutinizer-ci.com/g/maxrsg/ramverk1-proj/build-status/main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maxrsg/ramverk1-proj/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/maxrsg/ramverk1-proj/?branch=main)
[![Build Status](https://travis-ci.com/maxrsg/ramverk1-proj.svg?branch=main)](https://travis-ci.com/maxrsg/ramverk1-proj)

## Installation guide

Clone the repo:
<pre>
$ git clone git@github.com:maxrsg/ramverk1-proj.git
</pre>

Navigate into the cloned project:
<pre>
$ cd ramverk1-proj/
</pre>

Install necessary dependencies with make:
<pre>
$ make install
</pre>

Create cache folders:
<pre>
$ mkdir cache && cd cache/ && mkdir anax && cd ../
</pre>

Insert tables into database:
<pre>
$ sqlite3 data/db.sqlite < sql/ddl/tables.sql
</pre>

#### That's it!

