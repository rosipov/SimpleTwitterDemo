TwitterApp
=========

This application makes queries to the Twitter REST Search API based on a user provided string. 

This single page web app is built with PHP on top of the Symfony2 framework and uses HTML, CSS and Javascript on the front end. 

When the user first loads the webpage (/twitter/) they are presented with a textbox and submit button stylized by the Bootstrap framework. After the user enters and submits a string it is passed via an AJAX call (using the jQuery library) to our controller (src/Controller/TweetController.php). A GET request is done by the controller using an open source class ( TwitterAPIExchange ) which makes the authorized GET call to the Twitter API using our credentials and search query. TwitterAPIExchange also handles the necessary web encoding which is necessary for certain queries such as :interior or @CBSi.

The results are returned in JSON format which are then decoded. An iterative loop cycles through our result and makes Tweet objects out of the relavent handle, created at and text values. An array containing our Tweet objects is serialized to JSON encoding and is sent back to the controller. The controller builds a Response object from this array and sends it to the front end.

Finally, upon success,javascript iterates through the JSON array and the results are displayed as blockquotes (again, stylized with Bootstrap) and hidden/shown using jQuery animations.

To test this application one can use the built-in web server provided with PHP5.4 or newer. From the /twitterapp/ directory, run 'php app/console server:run'. For more information on running this locally please read: http://symfony.com/doc/current/cookbook/web_server/built_in.html
