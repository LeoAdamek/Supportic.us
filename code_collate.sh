#!/bin/bash

for filename in $(find . -type f)
do
	f_type=$(file -b $filename)
	if [ "${f_type##* }" == "text" ]
	then
		echo "###################### FILE: ${filename} #######################" >> collated_code.txt
		cat ${filename} >> collated_code.txt
		echo "###################### END FILE ${filename} ####################" >> collated_code.txt
	fi
done
