import csv
import operator
import os
import time
import email
import getpass, imaplib
import os
import sys
import sqlite3

#pulling records from file and adding it to vector of vectors
def pullrecords(file):
    array = []    
    i = 0
    prev = 0
    temp = 0
    with open(file) as f:
        reader = csv.reader(f)
        for row in reader:
            if len(row) < 4:
                row[0] = str(row[0]) + ' ' + str(row[1])
                temp = float(row[2])
                row[1] = float(row[2]) - float(prev)
                prev = temp
                row[2] = row[1]
                array.append(row)
            else:
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


#comparing last 15 minutes to last hour
def compare(file3):
    conn = sqlite3.connect('fancontrol.db')
    c = conn.cursor()
    try:
        c.execute('''CREATE TABLE log (file text, min60tot real, min60avg real, min15tot real, fan text)''')
    except:
        print ''
    l = len(file3)
    lasthour = 0
    for i in range (1,5):
        lasthour = lasthour + file3[l-i][1]
    lastquater = file3[l-1][1]
    print 'Combined Last 60min : ' + str(lasthour)
    print '\nAverage 15min in last 60min : ' + str(lasthour/4)
    print '\nLast 15min : ' + str(lastquater) + '\n'
    fry1 = fry.split('\\')
    fry1 = fry1[1]
    if lastquater > lasthour/4:
	inst = [str(fry1),lasthour,lasthour/4,lastquater,'fan on']
        c.execute("INSERT INTO log VALUES (?,?,?,?,?)",inst)
        conn.commit()
        conn.close()
        semanticDB(str(fry1),lasthour,lasthour/4,lastquater,'fan on')
        return 1
    else:
        inst = [str(fry1),lasthour,lasthour/4,lastquater,'fan off']
        c.execute("INSERT INTO log VALUES (?,?,?,?,?)",inst)
        conn.commit()
        conn.close()
        semanticDB(str(fry1),lasthour,lasthour/4,lastquater,'fan off')
        return 0


#enables or disables fan rotation
def fancontrol(input):
    import wiringpi2 as wiringpi
    OUTPUT = 1
    INPUT = 0
    wiringpi.wiringPiSetup()
    wiringpi.pinMode(8,OUTPUT)
    wiringpi.digitalWrite(8,input)


#prepares time for file finding
def preptime(f0,f1,f2,f3,f4,f5,f6):
    f2 = str(f2)    
    if f3 < 10:
        f3 = '0' + str(f3)
    else:
        f3 = str(f3)
    if f4 < 10:
        f4 = '0' + str(f4)
    else:
        f4 = str(f4)
    if f5 < 10:
        f5 = '000' + str(f5)
    if f5 < 100:
        f5 = '00' + str(f5)
    if f5 < 1000:
        f5 = '0' + str(f5)
    else:
        f5 = str(f5)
    ftry = f1 + f0 + f2 + f0 + f3 + f0 + f4 + f0 + f5 + f6
    return ftry
 
       
#finds the name of the file in the directory      
def findname(files):
    f0 = '_'    
    f1 = 'Downloads\DetailedSteps'
    f2 = 2015
    f3 = 01
    f4 = 01
    f5 = 0000
    f6 = '.csv'
    for i2 in range (2015,2017):
        f2 = i2
        for i3 in range(1,12):
            f3 = i3
            for i4 in range(1,31):
                f4 = i4
                for i5 in range (0,2399):
                    f5 = i5
                    fil = preptime(f0,f1,f2,f3,f4,f5,f6)
                    #print fil
                    try:
                        f = open(fil)
                        yes = 0
                        for file in files:
                            if file == fil:
                                yes = 1
                        if yes == 0:
                            print 'File Found : ' + fil + '\n'
                            files.append(fil)
                            return fil
                    except:
                        continue

#creates the summary of last hour and compares it to last 15 minutes
def executesummary(ftry):
    file1 = pullrecords(ftry)
    filed1 = compare(file1)
    if filed1 == 1:
        print 'Fan turns on\n'
    if filed1 == 0:
        print 'Fan turns off\n'
    #fancontrol(filed1)


#saves the files that already were explored    
def savefiles(files):
    z = open('files.txt', 'w')
    for file in files:
        file.strip(' ')
        z.write(file+'\n')


#opens files at the begining of the program
def openfiles(files):
    try:    
        x = open('files.txt', 'r')
        for line in x:
            if line != '':
                if line != '\n':
                    line = line.strip(' ')
                    line = line.strip('\n')
                    files.append(line)
    except:
        print 'File files.txt not found\n'


#downloads email attachements from google email
def downloademail(usern,pasd):
    detach_dir = '.'
    if 'Downloads' not in os.listdir(detach_dir):
        os.mkdir('Downloads')
 
    try:
        imapSession = imaplib.IMAP4_SSL('imap.gmail.com')
        typ, accountDetails = imapSession.login(usern, pasd)
        if typ != 'OK':
            print 'Not able to sign in!'
            raise
    
        imapSession.select('[Gmail]/All Mail')
        typ, data = imapSession.search(None, 'ALL')
        if typ != 'OK':
            print 'Error searching Inbox.'
            raise
    
        # Iterating over all emails
        for msgId in data[0].split():
            typ, messageParts = imapSession.fetch(msgId, '(RFC822)')
            if typ != 'OK':
                print 'Error fetching mail.'
                raise
 
            emailBody = messageParts[0][1]
            mail = email.message_from_string(emailBody)
            for part in mail.walk():
                if part.get_content_maintype() == 'multipart':
                    # print part.as_string()
                    continue
                if part.get('Content-Disposition') is None:
                    # print part.as_string()
                    continue
                fileName = part.get_filename()
 
                if bool(fileName):
                    filePath = os.path.join(detach_dir, 'Downloads', fileName)
                    if not os.path.isfile(filePath) :
                        print fileName
                        fp = open(filePath, 'wb')
                        fp.write(part.get_payload(decode=True))
                        fp.close()
        imapSession.close()
        imapSession.logout()
    except :
        print 'Not able to download all attachments.'  

def dbdisplay():
    conn = sqlite3.connect('fancontrol.db')
    c = conn.cursor()
    c.execute("SELECT * FROM log")
    print 'Database Content'
    for row in c.execute('SELECT * FROM log ORDER BY file'):
        print row
    print ' '
    conn.close()

def opendbfiles(files):
    try:    
        x = open('fancontrol.owl', 'r')
        for line in x:
            files.append(line)
    except:
        print 'File files.txt not found\n'
      
def findInd(files):
    ct = 0
    for line in files:
        if '#    Individuals' in line:
            return ct
        ct += 1 
    return -1
    
def findAdn(files):
    ct = 0
    for line in files:
        if '#    Annotations' in line:
            return ct
        ct += 1 
    return -1

def disjoin(files, arr1, arr2, adn):
    ct = 0
    for line in files:
        if ct < adn-4:
            arr1.append(line)
        else:
            arr2.append(line)
        ct += 1

def addRecWithoutInd(arr3, fn, t60, a60, t15, fc):
    arr3.append('\n')
    arr3.append('\n')
    arr3.append('#################################################################\n')
    arr3.append('#\n')
    arr3.append('#    Individuals\n')
    arr3.append('#\n')
    arr3.append('#################################################################\n')
    arr3.append('\n')
    arr3.append('\n')
    fn1 = '###  http://www.semanticweb.org/eclipse/ontologies/2015/6/untitled-ontology-60#' + str(fn) + '\n'
    arr3.append(fn1)
    arr3.append('\n')
    fn2 = ':' + str(fn) + ' rdf:type :DataRecord ,\n'
    arr3.append(fn2)
    arr3.append('                                            owl:NamedIndividual ;\n')
    arr3.append('\n')
    t60 = '                                   :Min60Total ' + str(t60) + ' ;\n'
    arr3.append(t60)
    arr3.append('\n')
    a60 = '                                   :Min60Average ' + str(a60) + ' ;\n'
    arr3.append(a60)
    arr3.append('\n')
    t15 = '                                   :Min15Total ' + str(t15) + ' ;\n'
    arr3.append(t15)
    arr3.append('\n')
    fn3 = '                                   :FileName "' + str(fn) + '" ;\n'
    arr3.append(fn3)
    arr3.append('\n')
    fc = '                                   :FanControl "' + str(fc) + '" .\n'
    arr3.append(fc)
    arr3.append('\n')
    arr3.append('\n')
    arr3.append('\n')

def addRecWithInd(arr3, fn, t60, a60, t15, fc):
    fn1 = '###  http://www.semanticweb.org/eclipse/ontologies/2015/6/untitled-ontology-60#' + str(fn) + '\n'
    arr3.append(fn1)
    arr3.append('\n')
    fn2 = ':' + str(fn) + ' rdf:type :DataRecord ,\n'
    arr3.append(fn2)
    arr3.append('                                            owl:NamedIndividual ;\n')
    arr3.append('\n')
    t60 = '                                   :Min60Total ' + str(t60) + ' ;\n'
    arr3.append(t60)
    arr3.append('\n')
    a60 = '                                   :Min60Average ' + str(a60) + ' ;\n'
    arr3.append(a60)
    arr3.append('\n')
    t15 = '                                   :Min15Total ' + str(t15) + ' ;\n'
    arr3.append(t15)
    arr3.append('\n')
    fn3 = '                                   :FileName "' + str(fn) + '" ;\n'
    arr3.append(fn3)
    arr3.append('\n')
    fc = '                                   :FanControl "' + str(fc) + '" .\n'
    arr3.append(fc)
    arr3.append('\n')
    arr3.append('\n')
    arr3.append('\n')

def savedbfile(files):
    z = open('fancontrol.owl', 'w')
    for file in files:
        z.write(file)


def semanticDB(fn, t60, a60, t15, fc):
    files=[]
    arr1 = []
    arr2 = []
    arr3 = []
    opendbfiles(files)
    ind = findInd(files)
    adn = findAdn(files)
    disjoin(files,arr1,arr2, adn)
    if ind == -1:
        addRecWithoutInd(arr3, str(fn), str(t60), str(a60), str(t15), str(fc))
    else:
        addRecWithInd(arr3, str(fn), str(t60), str(a60), str(t15), str(fc))
    merge = []
    for line in arr1:
        merge.append(line)
    for line in arr3:
        merge.append(line)
    for line in arr2:
        merge.append(line)
    savedbfile(merge)


#main function that runs the program
files = []
openfiles(files)
#fancontrol(0)
while True:
    try:
        print 'Finding files\n'
        downloademail('cop5859@gmail.com','cop12345')
        fry = findname(files)
        #some = pullrecords('Downloads\DetailedSteps_2015_06_19_2253.csv')
        executesummary(fry)
        savefiles(files)
        dbdisplay()
        time.sleep(15)
    except:
        continue

    
#os.system("pause")



		
		

