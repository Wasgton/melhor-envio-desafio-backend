#!/bin/bash

composer install
composer run-script post-root-package-install
composer run-script post-create-project-cmd
/usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf