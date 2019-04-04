DELIMITER //
CREATE OR REPLACE PROCEDURE address_add (IN p_address VARCHAR (90), IN p_info VARCHAR (90))
  BEGIN
    INSERT INTO address (address.address_name, address.address_info) VALUES (p_address, p_info);
  END;
//
CREATE OR REPLACE PROCEDURE address_remove (IN p_id INT(11))
  BEGIN
    DELETE FROM address WHERE address.address_id = p_id;
  END;
//
CREATE OR REPLACE PROCEDURE allergen_add (IN p_allergen VARCHAR (45))
  BEGIN
    INSERT INTO allergen (allergen.allergen_name) VALUES (p_allergen);
  END;
//
CREATE OR REPLACE PROCEDURE allergen_remove (IN p_id INT(11))
  BEGIN
    DELETE FROM allergen WHERE allergen.allergen_id = p_id;
  END;
//
CREATE OR REPLACE PROCEDURE category_add (IN p_name VARCHAR (45))
  BEGIN
    INSERT INTO category (category.category_name) VALUES (p_name);
  END;
//
CREATE OR REPLACE PROCEDURE category_remove (IN p_id INT(11))
  BEGIN
    DELETE FROM category WHERE category.category_id = p_id;
  END;
//
CREATE OR REPLACE PROCEDURE client_add (IN p_email VARCHAR (45),IN p_password VARCHAR (45),IN p_name VARCHAR (45),IN p_surname VARCHAR (45))
  BEGIN
    INSERT INTO client (client.client_email,client.client_password,client.client_name,client.client_surname) VALUES (p_email,p_password,p_name,p_surname);
  END;
//
CREATE OR REPLACE PROCEDURE client_remove (IN p_id INT(11))
  BEGIN
    DELETE FROM client WHERE client.client_id = p_id;
  END;
//
CREATE OR REPLACE PROCEDURE client_allergen_add (IN p_clientId INT (11),IN p_allergenId INT (11))
  BEGIN
    INSERT INTO client_allergen (client_allergen.client_id,client_allergen.allergen_id) VALUES (p_clientId,p_allergenId);
  END;
//
CREATE OR REPLACE PROCEDURE client_allergen_remove (IN p_clientId INT(11),IN p_allergenId INT(11))
  BEGIN
    DELETE FROM client_allergen WHERE client_allergen.client_id = p_clientId AND client_allergen.allergen_id = p_allergenId;
  END;
//
CREATE OR REPLACE PROCEDURE client_order_add (IN p_clientId INT (11),IN p_orderId INT (11))
  BEGIN
    INSERT INTO client_order (client_order.client_id,client_order.order_id) VALUES (p_clientId,p_orderId);
  END;
//
CREATE OR REPLACE PROCEDURE client_order_remove (IN p_clientId INT(11),IN p_orderId INT(11))
  BEGIN
    DELETE FROM client_order WHERE client_order.client_id = p_clientId AND client_order.order_id = p_orderId;
  END;
//
CREATE OR REPLACE PROCEDURE ingredient_add (IN p_name VARCHAR (45),IN p_allergenId INT (11))
  BEGIN
    INSERT INTO ingredient (ingredient.ingredient_name,ingredient.allergen_id) VALUES (p_name,p_allergenId);
  END;
//
CREATE OR REPLACE PROCEDURE ingredient_remove (IN p_id INT(11))
  BEGIN
    DELETE FROM ingredient WHERE ingredient.ingredient_id = p_id;
  END;
//
CREATE OR REPLACE PROCEDURE order_add (IN p_address VARCHAR (90))
  BEGIN
    INSERT INTO `order` (order.order_address) VALUES (p_address);
  END;
//
CREATE OR REPLACE PROCEDURE order_remove (IN p_id INT(11))
  BEGIN
    DELETE FROM `order` WHERE order.order_id = p_id;
  END;
//
CREATE OR REPLACE PROCEDURE order_status_add (IN p_orderId INT(11),IN p_statusId INT(11))
  BEGIN
    INSERT INTO order_status (order_status.order_id,order_status.status_id) VALUES (p_orderId,p_statusId);
  END;
//
CREATE OR REPLACE PROCEDURE order_status_remove (IN p_orderId INT (11),IN p_statusId INT (11))
  BEGIN
    DELETE FROM order_status WHERE order_status.order_id = p_orderId AND order_status.status_id = p_statusId;
  END;
//
CREATE OR REPLACE PROCEDURE product_add (IN p_name VARCHAR(45), IN p_price FLOAT, IN p_providerId INT(11))
  BEGIN
    INSERT INTO product (product.product_name,product.product_price,product.provider_id) VALUES (p_name,p_price,p_providerId);
  END;
//
CREATE OR REPLACE PROCEDURE product_remove (IN p_id INT(11))
  BEGIN
    DELETE FROM product WHERE product.product_id = p_id;
  END;
//
CREATE OR REPLACE PROCEDURE product_ingredient_add (IN p_productId INT(11), p_ingredientId INT(11))
  BEGIN
    INSERT INTO product_ingredient (product_ingredient.product_id,product_ingredient.ingredient_id) VALUES (p_productId,p_ingredientId);
  END;
//
CREATE OR REPLACE PROCEDURE product_ingredient_remove (IN p_productId INT(11), p_ingredientId INT(11))
  BEGIN
    DELETE FROM product_ingredient WHERE product_ingredient.product_id = p_productId AND product_ingredient.ingredient_id= p_ingredientId;
  END;
//
CREATE OR REPLACE PROCEDURE product_order_add (IN p_productId INT(11), p_orderId INT(11), IN p_notes VARCHAR(180))
  BEGIN
    INSERT INTO product_order (product_order.product_id,product_order.order_id,product_order.notes) VALUES (p_productId,p_orderId,p_notes);
  END;
//
CREATE OR REPLACE PROCEDURE product_order_remove (IN p_productId INT(11),p_orderId INT(11))
  BEGIN
    DELETE FROM product_order WHERE product_order.product_id = p_productId AND product_order.order_id= p_orderId;
  END;
//
CREATE OR REPLACE PROCEDURE provider_add (IN p_name VARCHAR (90),IN p_address VARCHAR (90),IN p_email VARCHAR (45),IN p_password VARCHAR (45),p_typeId INT(11))
  BEGIN
    INSERT INTO provider (provider.provider_name,provider.provider_address,provider.provider_email,provider.provider_password,provider.type_id) VALUES (p_name,p_address,p_email,p_password,p_typeId);
  END;
//
CREATE OR REPLACE PROCEDURE provider_remove (IN p_id INT(11))
  BEGIN
    DELETE FROM provider WHERE provider.provider_id = p_id;
  END;
//
CREATE OR REPLACE PROCEDURE provider_category_add (IN p_providerId INT(11), p_categoryId INT(11))
  BEGIN
    INSERT INTO provider_category (provider_category.provider_id,provider_category.category_id) VALUES (p_providerId,p_categoryId);
  END;
//
CREATE OR REPLACE PROCEDURE provider_category_remove (IN p_providerId INT(11),p_categoryId INT(11))
  BEGIN
    DELETE FROM provider_category WHERE provider_category.provider_id = p_providerId AND provider_category.category_id= p_categoryId;
  END;
//
CREATE OR REPLACE PROCEDURE status_add (IN p_name VARCHAR (45))
  BEGIN
    INSERT INTO status (status.status_name) VALUES (p_name);
  END;
//
CREATE OR REPLACE PROCEDURE status_remove (IN p_id INT(11))
  BEGIN
    DELETE FROM status WHERE status.status_id = p_id;
  END;
//
CREATE OR REPLACE PROCEDURE type_add (IN p_name VARCHAR (45))
  BEGIN
    INSERT INTO type (type.type_name) VALUES (p_name);
  END;
//
CREATE OR REPLACE PROCEDURE type_remove (IN p_id INT(11))
  BEGIN
    DELETE FROM type WHERE type.type_id = p_id;
  END;
//
