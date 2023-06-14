ROUTE	GET

/quotes/  All quotes are returned

/quotes/?id=4	The specific quote

/quotes/?author_id=10	All quotes from author_id=10

/quotes/?category_id=8	All quotes in category_id=8

/quotes/?author_id=3&category_id=4	All quotes from authorId=3 that are in category_id=4

/authors/	All authors with their id

/authors/?id=5	The specific author with their id

/categories/	All categories with their ids (id, category)

/categories/?id=7	The specific category with its id

ROUTE	POST	PUT	DELETE

/quotes/	created quote (id, quote, author_id, category_id)	updated quote (id, quote, author_id, category_id)	id of deleted quote

/authors/	created author (id, author)	updated author (id, author)	id of deleted author

/categories/	created category (id, category)	updated category (id, category)	id of deleted category

API: https://backendwebdev1midterm.dustinbriley.repl.co/
