#!/bin/bash
mysqldump -u user -ppass joydb > /var/www/kissabe/code/meta/joy.sql

mv /var/www/backup/*.tgz /var/www/backup/archives
tar cvzf $(date '+/var/www/backup/kissabe-%Y%m%d%H%M%S.tgz /var/www/joydb')
