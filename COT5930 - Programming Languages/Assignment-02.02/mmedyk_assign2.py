__author__ = 'Maciej Medyk'
from flask import Flask
from index import indexPage
from about import aboutPage
from post import postPage

app = Flask(__name__)

@app.route("/")
def index():
    return indexPage()

@app.route("/about/")
def about():
    return aboutPage()

@app.route('/post/<post_name>/')
def post(post_name):
    return postPage(post_name)


if __name__ == "__main__":
    app.run(debug=True, host='127.0.0.1', port=9000)