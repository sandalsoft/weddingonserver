#!/bin/bash

echo "db.copyDatabase('weddingonsand', 'weddingonsand', 'staff.mongohq.com:10004', 'mongohqdba', 'ilikebigtits');" | /usr/bin/mongo
/usr/bin/mongodump -o /var/www/wedding/db_backup/dump
cd /var/www/wedding/db_backup
tar czf mongo_dump.`date +%s`.tgz dump/

