# PHP Script for Database Connection and XML File Generation

---

A PHP script has been developed to connect to a database, retrieve all products, and save them in an XML file named `products.xml`. This file is stored in the same directory as the PHP script.

## Data Source:
- **Products**: Sourced from the `product` table.
- **Product Descriptions**: Found in the `product_description` table.
- **Product Special Offers**: Listed in the `product_special` table.

## XML File Data Structure:
1) **Model**: Product model from the `product.model` field.
2) **Status**: Indicates if the product is active (1) or inactive (0), from the `product.status` field.
3) **Name**: Product name in three languages, stored in the `product_description` table.
   - **Name in Latvian (LV)**: Identified by language code 1
   - **Name in English (ENG)**: Identified by language code 2
   - **Name in Russian (RU)**: Identified by language code 3
4) **Description**: Shortened product description in three languages (up to 200 characters with ellipsis), without breaking words in the middle. Found in the `product_description` table.
   - **Description in Latvian (LV)**: Language code 1
   - **Description in English (ENG)**: Language code 2
   - **Description in Russian (RU)**: Language code 3
5) **Quantity**: Product stock quantity from the `product.quantity`.
6) **EAN**: Product barcode from the `product.ean`.
7) **Image URL**: Product image path from `product.image`, prefixed with the base URL.
8) **Date Added**: Date of product addition in the format d-m-Y, from `product.date_added`.
9) **Price**: Product price from `product.price`.
10) **Special Price**: Discounted price from `product_special` if today's date (NOW) is less or equal to `date_end`.

### Pricing Details:
- All prices are displayed with a 21% VAT included, rounded to two decimal places. Decimals are shown even if they are zero.

## Repository Contents:
- The generated XML file `products.xml` from sample SQL data.
- The script is compatible with MySQL version 5.7.39 and PHP 7.4.

## Running the Script:
Requirements: MySQL 5.7.39 and PHP 7.4
1) Clone or download this Git repository.
2) Create a MySQL database and import the `webdev_test.sql` file into your MySQL database.
3) Open the project with a code editor (e.g., Visual Studio Code).
4) In the `index.php` file, fill in the following fields:
   - `$database_hostname`: Your MySQL hostname or IP address (e.g., localhost).
   - `$database_username`: Your MySQL username (e.g., root).
   - `$database_password`: Your MySQL password, leave empty if not applicable.
   - `$database_name`: Your MySQL database name (e.g., webdev).
5) Run the script in the terminal from the directory containing `index.php` using the command:

```bash
php index.php
