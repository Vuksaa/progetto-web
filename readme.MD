# Links
* [DOC](https://docs.google.com/document/d/1yc5-OVwv479ZF38MzWlKc9_w-5nIRfYCWxpPrJ_8tp4/edit)
* [Google Sheets page](https://docs.google.com/spreadsheets/d/18Ro4jAbf_LOkBPr_DmGApGaRwqbGOY-PE3fro7E6BCI/edit#gid=0)
* [Database](https://www.draw.io/#G19gvFu-5DhesNLPpEbtIoWQu4_ogbwmRx)

# TODOs:
* Create fragments for cards (eg. provider cards in home_clients.php)
* Load a limited amount of providers, products, etc at a time and use [infinite scrolling](https://stackoverflow.com/questions/5059526/infinite-scroll-jquery-plugin/5059561#5059561) to load more when necessary
* Consider allowing providers to upload preview/promo images of their products.
* Consider allowing providers to select a number of their products, in order to show them for a quick peek when deciding where to order? We would need to add something to the database for this
* Consider adding tutorials/explanations for when a client/provider first uses a certain function? Eg. when first ordering, creating a product, etc.. a modal is shown that explains everything
* Explore LESS? https://stackoverflow.com/questions/1065435/can-a-css-class-inherit-one-or-more-other-classes
## DONE:
* Make footers stay at the bottom of the pages

# To dump a database
* Navigate to your Xampp directory.
* Go to mysql\bin
* Run the following command: `mysqldump -u root -p uni_web_prod > filename.sql`
* Password is (should be) blank
