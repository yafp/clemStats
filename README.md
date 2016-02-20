clemStats
=========

[![License](https://img.shields.io/badge/license-GPL3-brightgreen.svg)](LICENSE)


## about
clemStats is a web-based clementine database analyzer. It offers pre-defined sql-queries and shows the result in a full filterable table. I am using it as small helper to keep my library organized. It helps getting some extra-details out of your clementine database.


## installation
- download the latest master from github
- extract the archive
- copy the files to your webserver directory
- adjust the path to your local accessible clementine database in /conf/settings.php


## keep in mind
you shouldn't access your clementine db using clemStats while clementine is running. If you do so there is a small risk that you might wreck your database. While this never happend for me it could still happen even if clemStats only reads the clementine database but does no changes to it at any time.


## feedback
is welcome. Looking forward for additional query-ideas or any other submit.
