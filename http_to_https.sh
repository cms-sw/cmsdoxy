#!/bin/sh


for i in `find $1 -name "*htmlgz"`
do
echo $i
gunzip -S gz $i
export i=`echo $i | sed 's/htmlgz/html/g'`
sed -i 's/https/http/g' $i
sed -i 's/http/https/g' $i
gzip -S gz $i
#echo $i
done
