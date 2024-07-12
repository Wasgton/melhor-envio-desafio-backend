#!/bin/bash

composer install -n
composer run-script post-root-package-install -n 
composer run-script post-create-project-cmd -n
/usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf