#!/bin/sh

echo `cat $1 | awk 'BEGIN{FIELDWIDTHS = "6 5 1 4 1 3 1 1 4 1 3 8 8 8 6 6 6 4"}{if ($1 == "ATOM  "){print($6,$9,$8)}}' | awk '{print($1":"$2":"$3)}'|uniq|wc -l`
