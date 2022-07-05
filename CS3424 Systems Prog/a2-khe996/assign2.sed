#!/bin/bash

sed  -i.sav '/^X/d' $1
sed -E -i.sav 's/(^|\s)[a-z]{3}[0-9]{3}(\s|$)/\1XYZ000\2/g' $1
sed -E -i.sav 's/(^|\s)@[0-9]{8}(\s|$)/\1@XXXXXXXX\2/g' $1
sed -E -i.sav 's/(^|\s)[aAbBcCdDfF]\W?(\s|$)/\1X\2/g' $1
sed -E -i.sav 's/(^|\s)[0-4][.][0-9][0-9]?[0-9]?(\s|$)/\1X.X\2/g' $1

