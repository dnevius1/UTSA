#! /usr/bin/awk -f

#Script to list files per user and oldest/newest file 

BEGIN{	totFileCount=0
	totHiddenCount=0
	totDirCount=0
	totBytes=0
	totOtherFiles=0
	oldest="9999999999999999"
	youngest=0
	}
{

	if($3){
	user[$3]
	}

	if(match(substr($8,1,1),/\./) && match(substr($8,2,1),/[a-zA-Z]/)) { 
	   hiddenCount[$3]+=1
	   totHiddenCount+=1
   	}

	if($1 ~ /^d/) {
	   dirCount[$3]+=1
	   totDirCount+=1
   	}

	if($1 ~ /^d/ || $1 ~ /^-/ || $NF ~ /^\./) {
		totFileCount+=1
		}

	else if ($3){
		otherFiles[$3]+=1
		totOtherFiles+=1
		}

	if($3) {
	year=substr($6,1,4)
	month=substr($6,6,2)
	day=substr($6,9,2)
	hour=substr($7,1,2)
	min=substr($7,4,2)
	sec=substr($7,7,2)
	age=year month day hour min sec
		if(age > youngest) {
			youngest=age
			newestFile=$0
		}
		if(age < oldest) {
			oldest=age
			oldestFile=$0
		}
	}
} 

{
	if($3 in user) {
		fileCount[$3]+=1
		storageCount[$3]+=$5
		totBytes+=$5
		}
}

END{for(key in fileCount) {
	print "Username: " key
	print "  Files:"
	print "        All: " fileCount[key]
	print "     Hidden:" hiddenCount[key]
	print "Directories: " dirCount[key]
	print "Other: " otherFiles[key]
	print "Storage (B):" storageCount[key] " bytes\n"	
	}
	for(i in user) {
		users+=1
	}
	print "Oldest file: "
	print oldestFile 
	print "Newest file: "
	print newestFile 
	print "Total users: \t   " users
	print "Total files: "
	printf("%s       ( %d / %d )\n","All / Hidden", totFileCount, totHiddenCount)
	printf("%s %d\n","Total directories:", totDirCount)
	printf("%s %d\n", "Total others: ", totOtherFiles)
	printf("%s %d\n\n", "Storage (B):\t  ", totBytes)
	
}
