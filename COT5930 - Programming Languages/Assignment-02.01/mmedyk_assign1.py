"""
Instructions!
* I've written several tests for you
* There are several blank functions
Your job: make the functions do what it takes to pass the tests.
DO NOT:
* Modify the tests
* Use if/elif/else to simply return what the tests expect (will not count)
Submit 
* `YourFAUUserId_assign1.py`
* `YourFAUUserId_assign1.txt` with the passing test output
Questions? email: cportela+python@fau.edu
"""
student = {
    "name": "Maciej Medyk",
    "email": "mmedyk@fau.edu",
    "z_number": "Z15197421",
    "assigment": 1
}

import unittest


def ReturnInteger():
    """
    Return any integer
    """

    return 32
    pass

def ReturnGoogol():
    """
    Return Googol, without typing it out.
    googol (go?o'g�l?, -g?l)?
    n.	The number 10 raised to the power 100 (10100), written out
    	as the numeral 1 followed by 100 zeros.
    """

    return str(10 ** 100)

    pass

def ReturnFloat():
    """
    Return any float
    """

    return 1.31

    pass

def IntegerDivision(a, b):
    """
    Return `a` integer divided by `b`
    """

    return int(a / b)

    pass

def ReturnHelloWorld():
    """
    Return the string "Hello, World!"
    """

    return "Hello, World!"

    pass

def Hello(name):
    """
    Print "Hello, <name>!" where <name> is replaced with value of name
    If name is empty then use "World" instead.
    Do not use `+`
    """

    if name == None:
        return "Hello, World!"
    return "Hello, {}!".format(name)

    pass

def ReturnList():
    """
    Return a list
    """

    return []

    pass

def AppendItem(list):
    """
    Return the same lists with a new item in it
    """
    list.append(4)
    return list

    pass

def ReturnListCopy(list):
    """
    Return a copy of the list with the same contents
    """

    return list.copy()

    pass

def ReturnFirstLast(list):
    """
    List will be a list of any length with a string as the first and last
    items in that list.
    Return a string with
    * the first letter of the first string
    * the first string
    * the last string
    * the last letter of the last string
    So ["test", "chris"] would be "t test chris s"
    """

    return "{} {} {} {}".format((list[0])[0], list[0], list[len(list) - 1],(list[len(list) - 1])[len((list[len(list) - 1])) - 1])

    pass

def Base64(string):
    """
    Use the base64 package in the standard library to encode a string.
    Be sure to return a string, not bytes.
    Convert to strings using `str()`
    """

    import base64
    test_str = bytes(string, 'utf-8')
    b64_string = base64.encodebytes(bytes(test_str))
    return str(b64_string)

    pass


class NumberTests(unittest.TestCase):
    def testReturnInteger(self):
        result = ReturnInteger()
        self.assertEqual(type(result), int)

    def testReturnGoogolplex(self):
        result = ReturnGoogol()
        self.assertEqual(len(result), 101)

    def testReturnFloat(self):
        result = ReturnFloat()
        self.assertEqual(type(result), float)

    def testIntegerDivision(self):
        self.assertEqual(IntegerDivision(1, 2), 0)
        self.assertEqual(IntegerDivision(4, 2), 2)
        self.assertEqual(IntegerDivision(0.5, 1000), 0)


class StringTests(unittest.TestCase):
    def testReturnHelloWorld(self):
        self.assertEqual(ReturnHelloWorld(), "Hello, World!")

    def testReturnHello(self):
        self.assertEqual(Hello(None), "Hello, World!")
        self.assertEqual(Hello("Chris"), "Hello, Chris!")
        self.assertEqual(Hello("Dr. Huang"), "Hello, Dr. Huang!")


class ListTests(unittest.TestCase):
    def testReturnList(self):
        self.assertEqual(type(ReturnList()), list)

    def testAppendItem(self):
        test_list = [1, 2, 3]
        test_list_len = len(test_list)
        result = AppendItem(test_list)
        self.assertIs(test_list, result)
        self.assertEqual(len(test_list), test_list_len + 1)

    def testReturnListCopy(self):
        test_list = [1, 2, 3]
        copy_list = ReturnListCopy(test_list)
        self.assertIsNot(test_list, copy_list)
        self.assertEqual(test_list, copy_list)

    def testReturnFirstLast(self):
        test_list = ["test", 1, 2, 3, 4, "end"]
        result = ReturnFirstLast(test_list)
        self.assertEqual(result, "t test end d")


class StandardLibraryTests(unittest.TestCase):
    def testBase64(self):
        import base64

        test_str = "test"
        b64_string = base64.encodebytes(bytes(test_str, 'utf-8'))
        result = Base64(test_str)
        self.assertEqual(type(result), str)
        self.assertEqual(str(b64_string), result)


if __name__ == '__main__':
    unittest.main()

