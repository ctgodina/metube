#!/bin/bash

while true; do
echo
echo "Select a CMD?"
echo

Files=("empty");
Count=1 
for f in *.*;
do
  if [ "${0:2}" != "$f" ] && [ "${f: -3}" == ".sh" ]; then 
    echo ${0:2};
    echo $Count. $f;
    let "Count +=1";
    Files=("${Files[@]}" $f)
  fi 
done

echo -n "Enter your choice, or 0 for exit: "
read choice
echo

if [ "$choice" == "0" ]; then break; fi
if [ "$choice" -ge "${#Files[@]}" ]; then echo "Invalid choice."; continue; fi

echo Running ${Files[$choice]}...
echo
./${Files[$choice]}

done


