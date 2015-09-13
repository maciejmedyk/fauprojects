import csv
import operator
import os
from tabulate import tabulate

#pulling records from file and adding it to vector of vectors
def pullrecords(file):
    array = []    
    i = 0
    with open(file) as f:
        reader = csv.reader(f)
        for row in reader:
            i = i + 1
            temp = row[0].split(', ')
            row.append(temp[0])
            if len(temp) > 1:
                tim = temp[1].split(' -')
                row.append(tim[0])
            if len(row) == 8:
                row[1] = float(row[1])
                row[2] = float(row[2])
                row[3] = float(row[3])
                row[4] = float(row[4])
                row[5] = float(row[5])
            array.append(row)
    return array

#grouping records by date
def groupbyday(file1, index):
    print("\nGrouping data by date")
    narr = []
    for item in file1:
	if len(item) == 8:
		item[0] = item[6]
		del(item[7])
		del(item[6])
	k = 0
	for i in range(0,len(narr)):
		
		if item[index] in narr[i][index]:
		    narr[i][1] = narr[i][1] + item[1]
                    narr[i][2] = narr[i][2] + item[2]
                    narr[i][3] = narr[i][3] + item[3]
                    narr[i][4] = narr[i][4] + item[4]
                    narr[i][5] = narr[i][5] + item[5]
		    k = 1
	if k == 0:
		narr.append(item)
    return narr 

#grouping records by an hour    
def groupbyhour(file2, index):
    print("\nGrouping data by hour")
    tarr = []
    for item in file2:
	if len(item) == 8:
		item[0] = item[7]
		del(item[7])
		del(item[6])
                t = item[0].split(':')
		if len(t) > 1:
		    item.append(t[0]+':'+t[2])
		    item[0] = item[6]
		    del(item[6])
	k = 0
	for i in range(0,len(tarr)):
		
		if item[index] in tarr[i][index]:
		    tarr[i][1] = tarr[i][1] + item[1]
                    tarr[i][2] = tarr[i][2] + item[2]
                    tarr[i][3] = tarr[i][3] + item[3]
                    tarr[i][4] = tarr[i][4] + item[4]
                    tarr[i][5] = tarr[i][5] + item[5]
		    k = 1
	if k == 0:
		tarr.append(item)
    tarr[0][0] = 'time'
    return tarr 
    
    
file1 = pullrecords('DetailedSteps.csv')
file2 = pullrecords('DetailedSteps.csv')
filed1 = groupbyday(file1, 0)
print tabulate(filed1)
filed2 = groupbyhour(file2, 0)
print tabulate(filed2)

#os.system("pause")



		
		

