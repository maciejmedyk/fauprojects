def postPage(post_name):
    string = """<!DOCTYPE HTML>
        <html>
        <html>
        <head>
        <title>Flask Assignment - Maciej Medyk</title>
        <style>
            #navmenu{background-color: #eee; text-align: right;}
            a {text-decoration: none; color: #000;}
            #main {float: left; margin: 10px 30%; text-align: left; background-color: #eee; padding: 20px; min-width: 40%; color: #7f7f7f;}
            body {font-family: 'Lucida Grande', 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 20px 0px 150px; font-size: 13px; text-align: center; text-decoration: none; background: #e0e0e0;}
            ul {text-align: left; display: inline; margin: 0; padding: 15px 4px 17px 0; list-style: none; -webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.15); -moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.15); box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);}
            ul li {font: bold 12px/18px sans-serif; display: inline-block; margin-right: -4px; position: relative; padding: 15px 20px; background: #fff; cursor: pointer; -webkit-transition: all 0.2s; -moz-transition: all 0.2s; -ms-transition: all 0.2s; -o-transition: all 0.2s; transition: all 0.2s;}
            ul li:hover {background: #555; color: #fff;}
            ul li ul {padding: 0; position: absolute; top: 48px; left: 0; width: 150px; -webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; display: none; opacity: 0; visibility: hidden; -webkit-transiton: opacity 0.2s; -moz-transition: opacity 0.2s; -ms-transition: opacity 0.2s; -o-transition: opacity 0.2s; -transition: opacity 0.2s;}
            ul li ul li {background: #555; display: block; color: #fff; text-shadow: 0 -1px 0 #000;}
            ul li ul li:hover { background: #666; color: #fff;}
            ul li ul li:hover { background: #666; color: #fff;}
            ul li:hover ul {display: block; opacity: 1; visibility: visible;}
            ul li:hover a {text-decoration: none; color: #fff;}
        </style>
        </head>
        <body>
        <div id='navmenu'>
            <ul><li>Post
                <ul>
                <li><a href="/post/class_cop5930">Class: COP 5930</a></li>
                <li><a href="/post/class_cop5339">Class: COP 5339</a></li>
                <li><a href="/post/class_cot4010">Class: COT 4010</a></li>
                <li><a href="/post/class_mas2103">Class: MAS 2103</a></li>
                <li><a href="/post/class_cot4935">Class: COT 4935</a></li>
                </ul>
                </li>
                <li><a href='/about/'>About</a></li>
                <li><a href='/'>Home</a></li>
            </ul>
        </div>
        """

    if post_name == 'class_cop5930':

        return string + """
            <div id="main">
            <h2>COP 5930 - Programming Languages</h2>
            <p>In Programming Languages class we are learning history of languages and how they developed over time and compare syntax similarities between them.
            During the course we learned language grammar that is a topic touched upon in Formal Languages class. We also touched upon new, commonly used languages like Python and C++.
            From python assignments we had to learn how to unit test and how to make a website using Flask platform.</p>
            <p>Here we discovered that Python is really fun language in which indentation matters, but because of that language gains on readability.
            We also noticed we do not need to create set or get methods with Python objects. I personally liked the Flask platform as it allows to deploy the site instantly on any platform.</p>
            </div>
        </body>
        </html>"""

    if post_name == 'class_cop5339':

        return string + """
            <div id="main">
            <h2>COP 5339 - Object Oriented Design and Programming</h2>
            <p>In Object Oriented Design and Programming class we are learning how to design a program that uses classes and methods and how to program it in Java.
            During the course we learned how to build program designs in Unified Modeling Language and express it in form of class, state, and sequence diagram.
            Throughout the class with had various assignments that included Java programming and final project was design and implementation of Shopping Cart application.</p>
            </div>
        </body>
        </html>"""

    if post_name == 'class_cot4010':

        return string + """
            <div id="main">
            <h2>COT 4010 - Principles of Software Engineering</h2>
            <p>In Principles of Software Engineering class we are learning how to work in team to design an application according to specifications.
            During the course we worked on project to help local chapter of Meals on Wheels with their delivery execution and tracking.
            While working on the project we worked in groups and employed scrum and agile methodologies to develop the software and track our progress.</p>

            </div>
        </body>
        </html>"""

    if post_name == 'class_mas2103':

        return string + """
            <div id="main">
            <h2>MAS 2103 - Matrix Theory</h2>
            <p>In Matrix Theory class we are learning how to work with matrices. We learned addition, multiplication, deriving identity matrix, calculate determinant.
            The class is focused also on vectors, vector spaces, and vector subspaces. The matrix theory is very useful in computer science field and has real world applications.
            Class is divided into four tests and a final. Its a class that requires a lot of work and self learning.</p>

            </div>
        </body>
        </html>"""

    if post_name == 'class_cot4935':

        return string + """
            <div id="main">
            <h2>COT 4935 - Senior Seminar</h2>
            <p>In Senior Seminar class we are learning how field of computer science creates potential ethical issues. We are learning of potential hazards that exists
            that are associated with exploitation of computer systems, illegal activities associated with hacking and dark web, privacy laws, intellectual propery laws.
            During the class we showcased many issues that come with technological evolution and software development.</p>

            </div>
        </body>
        </html>"""