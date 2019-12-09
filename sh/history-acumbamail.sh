#!/bin/bash

date=$(date '+%Y/%m/%d %H'):00

cd ..
php bin/console app:sms-history-acumbamail "$date:00"
cd sh
