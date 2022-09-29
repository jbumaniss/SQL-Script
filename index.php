<?php




$mysqli = new mysqli('127.0.0.1', 'root', 'Redalert2', 'webdev');
if ($mysqli->connect_errno) {
    echo "Connection failed " . $mysqli->connect_error;
    exit();
}
$products = [];
$sql = "SELECT 
    product.product_id,
    model,
    quantity,
    ean,
    image,
    date_added,
    product.price,
    status,
    ANY_VALUE(product_special.price) AS special_price,
    ANY_VALUE(product_special.date_end) AS date_end,
    MAX(CASE WHEN language_id = 1 THEN name END) AS namelv,
    MAX(CASE WHEN language_id = 2 THEN name END) AS nameeng,
    MAX(CASE WHEN language_id = 3 THEN name END) AS nameru,
    MAX(CASE WHEN language_id = 1 THEN description END) AS descriptionlv,
    MAX(CASE WHEN language_id = 2 THEN description END) AS descriptioneng,
    MAX(CASE WHEN language_id = 3 THEN description END) AS descriptionru
    FROM product
    LEFT JOIN product_description
    ON product.product_id = product_description.product_id
    LEFT JOIN product_special
    ON product.product_id= product_special.product_id
    GROUP BY product.product_id
    ORDER BY product_id";

if ($result = $mysqli->query($sql)) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
    if (count($products)) {
        $xml_file = createXmlFile($products);
        echo "XML file generated successfully";
    }else{
        echo "No Records Found";
    }
    $result->free();
}
$mysqli->close();

function createXmlFile($products){
    $file_path = 'products.xml';
    $dom = new DOMDocument('1.0', 'utf-8');
    $root = $dom->createElement('root');
    $root = $dom->appendChild($root);

    foreach ($products as $product) {
        $product_item = $dom->createElement('item');
        $product_item = $root->appendChild($product_item);
        $product_item->appendChild($dom->createElement('model', $product['model']));
        $product_item->appendChild($dom->createElement('status', $product['status']));
        $product_name = $dom->createElement('name');
        $product_name = $root->appendChild($product_name);
        $product_name->appendChild($dom->createElement('lv', $product['namelv']));
        $product_name->appendChild($dom->createElement('eng', $product['nameeng']));
        $product_name->appendChild($dom->createElement('ru', $product['nameru']));
        $product_item->appendChild($product_name);
        $product_name = $dom->createElement('description');
        $product_name = $root->appendChild($product_name);
        $product_name->appendChild($dom->createElement('lv', truncate($product['descriptionlv'],200)));
        $product_name->appendChild($dom->createElement('eng', truncate($product['descriptioneng'],200)));
        $product_name->appendChild($dom->createElement('ru',truncate($product['descriptionru'],200)));
        $product_item->appendChild($product_name);
        $product_item->appendChild($dom->createElement('quantity', $product['quantity']));
        $product_item->appendChild($dom->createElement('ean', $product['ean']));
        $product_item->appendChild($dom->createElement('image_url', "https://www.webdev.lv/" . $product['image']));
        $product_item->appendChild($dom->createElement('date_added', dateFormat(strtotime($product['date_added']))));
        $product_item->appendChild($dom->createElement('price', addPvn($product['price'])));
        $product_item->appendChild($dom->createElement('special_price', $product['date_end'] >= date('Y-m-d') ? addPvn($product['special_price']) : null));
        $root->appendChild($product_item);
    }
    $dom->appendChild($root);
    $dom->formatOutput = true;
    if ($dom->save($file_path)) {
        return $file_path;
    }
return false;
}

function truncate($string,$length=200,$append="..."): string {
    $string = trim($string);

    if(strlen($string) > $length) {
        $string = wordwrap($string, $length);
        $string = explode("\n", $string, 2);
        $string = $string[0] . $append;
    }

    return $string;
}

function dateFormat(string $date): string {
    return  date('d-m-Y', strtotime($date));
}

function addPvn(float $price, int $pvn = 21): string {
    return  number_format(("1." . $pvn) * $price,2);
}
