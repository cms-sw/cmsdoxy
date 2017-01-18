#!/bin/bash

for file in */auto.doc.2; do 
   file=`echo $file | cut -d "/" -f1`
   echo "$file will be deleted..."
   rm -rf $file
done
