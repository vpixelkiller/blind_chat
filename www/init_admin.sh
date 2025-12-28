#!/bin/bash

source /root/.env 2>/dev/null || true

php /var/www/html/init_admin.php

