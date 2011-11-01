#!/bin/bash


# CONFIG

# DEBUG: Set this to 1 if you want debug info
debug=1

lines=0
 
for file in $(find . -type f)
do
	ftype=$(file -ib ${file})
	if [ "${ftype%%/*}" == "text" ]
	then
		if [ $debug != 0 ]
		then
			echo "Counting lines from ${ftype} file ${file}"
		fi
		flines=$(cat ${file} | wc -l)
		lines=$[$lines+$flines]
	else
		if [ $debug != 0 ]
		then
			echo "Ignoring ${ftype} file ${file}"
		fi
	fi
done

echo "Lines of Code: ${lines}"
