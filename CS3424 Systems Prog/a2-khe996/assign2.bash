#!/bin/bash
i=1
for file in "$@"
do
	./assign2.sed $file
	i=$((i + 1))
done
