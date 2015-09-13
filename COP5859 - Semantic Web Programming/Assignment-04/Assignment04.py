from tabulate import tabulate
import os


def pullrecords(file):
    temp = []
    result = []
    x = open(file, 'r')
    for line in x:
        if "<rdf:Description rdf:about=" in line:
            result.append(temp)
            temp=[]
        temp.append(line)
    result.append(temp)
    del result[0]
    return result
    
def splitrecords(file,i):
    for item in file:
        item[i] = item[i].split('>')
        item[i] = item[i][1].split('<')
        item[i] = item[i][0]
    return file

def combinerecords(file1, file2):
    resultant = []
    for item1 in file1:
        for item2 in file2:
            if item1[3] == item2[3]:
                item1.append(item2[4])
                item1.append(item2[5])
                item1.append(item2[6])
                item1.append(item2[7])
                item1.append(item2[8])
                item1.append(item2[9])
                resultant.append(item1)
    return resultant
    
def clearout(file):
    ret = []
    for item in file:
        if len(item) > 12:
            if "<ds:ages_0_20>" in item[12]:
                if "<ds:ages_21_34>" in item[13]:
                    if "<ds:ages_35>" in item[14]:
                        if "<ds:all_ages>" in item[15]:
                            if "<ds:male>" in item[16]:
                                if "<ds:female>" in item[17]:
                                    ret.append(item)
    return ret
    
def streamline(t2):
    t2 = splitrecords(t2,4)
    t2 = splitrecords(t2,12)
    t2 = splitrecords(t2,13)
    t2 = splitrecords(t2,14)
    t2 = splitrecords(t2,15)
    t2 = splitrecords(t2,16)
    t2 = splitrecords(t2,17)
    for item in t2:
        del item[14]
        del item[13]
        del item[12]
        del item[11]
        del item[10]
        del item[9]
        del item[8]
        del item[7]
        del item[6]
        del item[5]
        del item[2]
        del item[1]
        del item[0]
    return t2


result1 = pullrecords("Drivers_Wearing_Seat_Belts_2012_All_States.rdf")
result2 = pullrecords("Impaired_Driving_Death_Rate_2012_All_States.rdf")

result11 = splitrecords(result1,3)
result21 = splitrecords(result2,3)

table1 = combinerecords(result11,result21)
table2 = clearout(table1)
table2 = streamline(table2)

headers = ['State', 'Seatbealt usage', 'Motor Vehicles deaths','Male deaths', 'Female deaths']

print tabulate(table2, headers)


#os.system("pause")