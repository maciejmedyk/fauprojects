def aboutPage():
    return"""
    <!DOCTYPE HTML>
    <html>
    <head>
    <title>Flask Assignment - Maciej Medyk</title>
    <style>
        #navmenu{ background-color: #eee; text-align: right;}
        #main {float: left; margin: 10px 30%; text-align: left; background-color: #eee; padding: 20px; min-width: 40%; color: #7f7f7f;}
        #left {float: left; margin-left: 20px;}
        #right {float: left; margin-left: 20px; text-align: left;}
        img {max-height: 200px;}
        a {text-decoration: none; color: #000;}
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
        <div id="navmenu">
            <ul><li>Post
                    <ul>
                    <li><a href="/post/class_cop5930">Class: COP 5930</a></li>
                    <li><a href="/post/class_cop5339">Class: COP 5339</a></li>
                    <li><a href="/post/class_cot4010">Class: COT 4010</a></li>
                    <li><a href="/post/class_mas2103">Class: MAS 2103</a></li>
                    <li><a href="/post/class_cot4935">Class: COT 4935</a></li>
                    </ul>
                </li>
                <li><a href="/about/">About</a></li>
                <li><a href="/">Home</a></li>
            </ul>
        </div>
        <div id="main">
        <div id="left">
            <img src="http://lamp.cse.fau.edu/~mmedyk/img/maciej-b.jpg">
        </div>
        <div id="right">
            <h2>Maciej Medyk</h2>
            <p>ID       : Z15197421</p>
            <p>Email    : mmedyk@fau.edu</p>
            <p>LinkedIn : www.linkedin.com/in/maciejmedyk</p>
            <p>Repository : www.github.com/maciejmedyk/fauprojects</p>
        </div>
        </div>
    </body>
    </html>"""