MetaDataMade-a-Easy
===================

PHP Class for Accessing Various Shopify Metafields for Customers, Products, and more

![Logo for SMYAYA Meta Data Made-a-Easy](/demos/meta-data-made-a-easy.jpg)

Picture this: 

You want to write a piece of info to meta - but you don't know if it exists yet! So you write some code to POST new JSON and another method to PUT it. Hooray - it's fun writing tons of extra code... right?

(wouldn't it be easier if you had just one PHP class to call? and if that class figured out on its own whether to POST or PUT? and by the way, what if this spiffy new class generated its own key if you do not pass it a define one?)


THEN you have a method that deletes an item from a local MySQLi database and then takes out the corresponding item from a Shopify Account's meta data. But you already deleted the meta item - OR DID YOU? So you send the DELETE cURL call - oops, you had deleted it yesterday. So now, have fun handling the resulting error.

(why not let this class take care of it for you?)


Or how about this old chestnut... everybody and their mother has already written millions of product meta options... but suppose you want to hop in there and take a look at the customer meta data? the store meta data? the order meta data?  It's a meta data tornada.

(why not just make a quick call to our spiffy new class... aaah, that was easy.)

MetaToolsMade-a-Easy is a class that handles all of the above with grace. It's pretty far along, but frankly is still under development here and there as I use it in our organizations own online registration Shopify store front.


What This Is
====================
This class extends Sandeep Shetty's wonderful Shopify PHP plugin. Once you get connected to Shopify with that plugin, this plugin uses that connection to access all kinds of meta data info - with style.


How You Can Help
====================
* Especially important is a good demo suite. Please help to add new features and functions to the demo page.
